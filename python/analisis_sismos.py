"""
Análisis de sismos con pandas y matplotlib.

Uso:  python analisis_sismos.py <archivo.csv> <carpeta_salida>

Lee el CSV descargado desde la API (manual-python/api/sismos.php, datos del USGS),
genera 6 gráficas (barras, histograma, dispersión, mapa de epicentros, dona y
barras horizontales) y escribe un resumen.json con los indicadores.
"""
import json
import os
import sys

carpeta = sys.argv[2] if len(sys.argv) > 2 else 'datos'
# matplotlib necesita una carpeta con permisos de escritura para su caché
os.environ.setdefault('MPLCONFIGDIR', os.path.join(carpeta, '.matplotlib'))

# OpenBLAS (usado por numpy/pandas) reserva memoria para un hilo por núcleo al arrancar;
# lanzado desde Apache esa reserva a veces falla. Con un solo hilo sobra.
for variable in ('OPENBLAS_NUM_THREADS', 'OMP_NUM_THREADS', 'MKL_NUM_THREADS'):
    os.environ.setdefault(variable, '1')

import logging

import pandas as pd
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as grafica

# ------------------------------------------------------------------
# Paleta y estilo
# ------------------------------------------------------------------
INDIGO = '#5A62D6'
INDIGO_CLARO = '#9AA3FF'
GRIS = '#6B7684'
ROJO = '#C0392B'
RAMPA_PROFUNDIDAD = ['#F28E5C', '#5A62D6', '#1E2A5A']   # superficial, intermedio, profundo
TEXTO = '#1E2733'
TEXTO_SUAVE = '#6B7684'
REJILLA = '#E3E7ED'

MESES = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
         'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
MESES_LARGOS = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
                'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']

# Si falta 'Segoe UI' (Linux/Docker) se usa DejaVu Sans sin llenar el log de avisos
logging.getLogger('matplotlib.font_manager').setLevel(logging.ERROR)

grafica.rcParams.update({
    'font.family': ['Segoe UI', 'DejaVu Sans'],
    'font.size': 10,
    'text.color': TEXTO,
    'axes.labelcolor': TEXTO_SUAVE,
    'axes.edgecolor': REJILLA,
    'axes.titlesize': 13,
    'axes.titleweight': 'bold',
    'axes.titlelocation': 'left',
    'axes.titlepad': 14,
    'axes.spines.top': False,
    'axes.spines.right': False,
    'axes.grid': True,
    'axes.axisbelow': True,
    'grid.color': REJILLA,
    'grid.linewidth': 0.8,
    'xtick.color': TEXTO_SUAVE,
    'ytick.color': TEXTO_SUAVE,
    'legend.frameon': False,
    'figure.facecolor': 'white',
    'savefig.dpi': 150,
})


def guardar(figura, nombre):
    figura.tight_layout()
    figura.savefig(os.path.join(carpeta, nombre))
    grafica.close(figura)


def nombre_mes(periodo):
    return f'{MESES_LARGOS[periodo.month - 1]} de {periodo.year}'


def fecha_larga(fecha):
    return f'{fecha.day} de {MESES_LARGOS[fecha.month - 1]} de {fecha.year}'


def numero(valor, decimales=1):
    # Formato colombiano: punto para miles y coma para decimales
    texto = f'{valor:,.{decimales}f}'
    return texto.replace(',', '_').replace('.', ',').replace('_', '.')


def zona_cercana(lugar):
    # "12 km SW of Los Santos, Colombia" -> "Los Santos, Colombia"
    lugar = str(lugar)
    return lugar.split(' of ', 1)[1].strip() if ' of ' in lugar else lugar.strip()


def pais(lugar):
    # "Los Santos, Colombia" -> "Colombia";  "Fiji region" -> "Fiji region"
    return str(lugar).rsplit(',', 1)[-1].strip()


# ------------------------------------------------------------------
# 1. Leer y limpiar los datos
# ------------------------------------------------------------------
archivo = sys.argv[1] if len(sys.argv) > 1 else 'datos/sismos.csv'
datos = pd.read_csv(archivo, encoding='utf-8-sig')
datos['fecha'] = pd.to_datetime(datos['fecha'], errors='coerce')
for columna in ('latitud', 'longitud', 'profundidad_km', 'magnitud'):
    datos[columna] = pd.to_numeric(datos[columna], errors='coerce')
datos = datos.dropna(subset=['fecha', 'magnitud', 'latitud', 'longitud']).sort_values('fecha')
datos['profundidad_km'] = datos['profundidad_km'].fillna(0).clip(lower=0)
datos['lugar'] = datos['lugar'].fillna('Sin ubicación')
datos['mes'] = datos['fecha'].dt.to_period('M')
datos['zona'] = datos['lugar'].map(zona_cercana)
datos['pais'] = datos['lugar'].map(pais)

if datos.empty:
    print('El CSV no tiene sismos válidos.')
    sys.exit(1)

# ¿Es un recorte regional o datos de todo el planeta?
es_mundial = (datos['longitud'].max() - datos['longitud'].min()) > 100
region = 'el mundo' if es_mundial else 'Colombia y alrededores'

os.makedirs(carpeta, exist_ok=True)

# ------------------------------------------------------------------
# Gráfica 1 - Barras: número de sismos por mes
# ------------------------------------------------------------------
por_mes = datos.groupby('mes').size()
etiquetas = [f'{MESES[p.month - 1]}\n{str(p.year)[2:]}' for p in por_mes.index]
posicion_max = int(por_mes.values.argmax())

figura, ejes = grafica.subplots(figsize=(9, 4.5))
colores = [INDIGO if i == posicion_max else INDIGO_CLARO for i in range(len(por_mes))]
barras = ejes.bar(etiquetas, por_mes.values, color=colores, width=0.72)
ejes.bar_label(barras, padding=3, fontsize=8, color=TEXTO_SUAVE)
ejes.set_title('Número de sismos por mes')
ejes.set_ylabel('Sismos')
ejes.grid(axis='x', visible=False)
guardar(figura, 'grafica1_sismos_mes.png')

# ------------------------------------------------------------------
# Gráfica 2 - Histograma: distribución de magnitudes
# ------------------------------------------------------------------
promedio = datos['magnitud'].mean()

figura, ejes = grafica.subplots(figsize=(9, 4.5))
# Las magnitudes vienen con un decimal: cada barra se centra en su valor (4,5 cubre 4,45-4,55)
inicio = round(datos['magnitud'].min(), 1) - 0.05
pasos = int(round((datos['magnitud'].max() - datos['magnitud'].min()) / 0.1)) + 1
limites = [inicio + 0.1 * i for i in range(pasos + 1)]
ejes.hist(datos['magnitud'], bins=limites, color=INDIGO, edgecolor='white', linewidth=1)
ejes.axvline(promedio, color=TEXTO, linewidth=1.5, linestyle='--')
ejes.annotate(f'Promedio {numero(promedio, 2)}', xy=(promedio, 1), xycoords=('data', 'axes fraction'),
              xytext=(6, -14), textcoords='offset points', fontsize=9, color=TEXTO)
ejes.set_title('Distribución de las magnitudes')
ejes.set_xlabel('Magnitud')
ejes.set_ylabel('Número de sismos')
ejes.grid(axis='x', visible=False)
guardar(figura, 'grafica2_histograma_magnitud.png')

# ------------------------------------------------------------------
# Gráfica 3 - Dispersión: profundidad vs magnitud
# ------------------------------------------------------------------
correlacion = datos['profundidad_km'].corr(datos['magnitud'])
if pd.isna(correlacion):
    correlacion = 0.0

figura, ejes = grafica.subplots(figsize=(9, 4.5))
ejes.scatter(datos['profundidad_km'], datos['magnitud'], s=22, color=INDIGO,
             alpha=0.55, edgecolors='white', linewidths=0.6)
ejes.set_title(f'Profundidad vs magnitud  (r = {numero(correlacion, 2)})')
ejes.set_xlabel('Profundidad (km)')
ejes.set_ylabel('Magnitud')
guardar(figura, 'grafica3_profundidad_magnitud.png')

# ------------------------------------------------------------------
# Gráfica 4 - Mapa de epicentros: longitud vs latitud
# (tamaño = magnitud, color = profundidad)
# ------------------------------------------------------------------
figura, ejes = grafica.subplots(figsize=(9, 4.5))
tamanos = (datos['magnitud'] - datos['magnitud'].min() + 0.5) ** 2.2 * 6
puntos = ejes.scatter(datos['longitud'], datos['latitud'], s=tamanos, c=datos['profundidad_km'],
                      cmap='viridis_r', alpha=0.75, edgecolors='white', linewidths=0.5)
barra = figura.colorbar(puntos, ax=ejes, fraction=0.035, pad=0.02)
barra.set_label('Profundidad (km)')
barra.outline.set_visible(False)
ejes.set_title('Mapa de epicentros (tamaño = magnitud)')
ejes.set_xlabel('Longitud')
ejes.set_ylabel('Latitud')
if not es_mundial:
    ejes.set_aspect('equal', adjustable='datalim')
guardar(figura, 'grafica4_mapa_epicentros.png')

# ------------------------------------------------------------------
# Gráfica 5 - Dona: sismos según la profundidad
# ------------------------------------------------------------------
categorias = pd.cut(datos['profundidad_km'], bins=[-0.1, 70, 300, float('inf')],
                    labels=['Superficial (< 70 km)', 'Intermedio (70-300 km)', 'Profundo (> 300 km)'])
conteo = categorias.value_counts().reindex(categorias.cat.categories).fillna(0).astype(int)

figura, ejes = grafica.subplots(figsize=(9, 4.5))
ejes.pie(conteo.values, colors=RAMPA_PROFUNDIDAD, startangle=90, counterclock=False,
         wedgeprops={'width': 0.42, 'edgecolor': 'white', 'linewidth': 2},
         autopct=lambda p: f'{p:.0f}%' if p >= 3 else '', pctdistance=0.79,
         textprops={'color': 'white', 'fontsize': 9, 'fontweight': 'bold'})
ejes.text(0, 0, f'{len(datos)}\nsismos', ha='center', va='center', fontsize=14, fontweight='bold')
ejes.legend([f'{c}: {n}' for c, n in conteo.items()], loc='center left', bbox_to_anchor=(1, 0.5))
ejes.set_title('Sismos según la profundidad')
ejes.axis('equal')
guardar(figura, 'grafica5_profundidad.png')

# ------------------------------------------------------------------
# Gráfica 6 - Barras horizontales: zonas con más sismos
# ------------------------------------------------------------------
agrupar_por = 'pais' if datos['pais'].nunique() >= 8 else 'zona'
top = datos[agrupar_por].value_counts().head(10).sort_values()

figura, ejes = grafica.subplots(figsize=(9, 4.5))
barras = ejes.barh(top.index, top.values, color=INDIGO, height=0.65)
ejes.bar_label(barras, padding=3, fontsize=8, color=TEXTO_SUAVE)
ejes.set_title('Países o regiones con más sismos' if agrupar_por == 'pais' else 'Zonas con más sismos')
ejes.set_xlabel('Sismos')
ejes.grid(axis='y', visible=False)
ejes.tick_params(axis='y', labelsize=8.5)
guardar(figura, 'grafica6_zonas.png')

# ------------------------------------------------------------------
# Resumen para el reporte
# ------------------------------------------------------------------
mayor = datos.loc[datos['magnitud'].idxmax()]
mes_activo = por_mes.idxmax()
mes_tranquilo = por_mes.idxmin()
zona_activa = top.index[-1]
fuertes = int((datos['magnitud'] >= 5).sum())
superficiales = int(conteo.iloc[0])
pct_superficiales = superficiales / len(datos) * 100

if correlacion >= 0.3:
    relacion = 'los sismos más profundos tienden a ser de mayor magnitud'
elif correlacion <= -0.3:
    relacion = 'los sismos más profundos tienden a ser de menor magnitud'
else:
    relacion = 'la profundidad y la magnitud casi no se relacionan'

resumen = {
    'region': region,
    'fecha_inicio': datos['fecha'].min().strftime('%Y-%m-%d'),
    'fecha_fin': datos['fecha'].max().strftime('%Y-%m-%d'),
    'total': int(len(datos)),
    'magnitud_media': round(float(promedio), 2),
    'magnitud_max': round(float(mayor['magnitud']), 1),
    'magnitud_max_fecha': mayor['fecha'].strftime('%Y-%m-%d'),
    'magnitud_max_lugar': str(mayor['lugar']),
    'profundidad_media': round(float(datos['profundidad_km'].mean()), 1),
    'fuertes': fuertes,
    'mes_activo': nombre_mes(mes_activo),
    'mes_activo_sismos': int(por_mes.max()),
    'zona_activa': str(zona_activa),
    'zona_activa_sismos': int(top.iloc[-1]),
    'correlacion': round(float(correlacion), 2),
    'por_profundidad': {str(c): int(n) for c, n in conteo.items()},
    'meses': [
        {'mes': nombre_mes(periodo), 'sismos': int(len(grupo)),
         'magnitud_media': round(float(grupo['magnitud'].mean()), 2),
         'magnitud_max': round(float(grupo['magnitud'].max()), 1),
         'profundidad_media': round(float(grupo['profundidad_km'].mean()), 1)}
        for periodo, grupo in datos.groupby('mes')
    ],
    'graficas': [
        {'archivo': 'grafica1_sismos_mes.png', 'titulo': 'Sismos por mes',
         'descripcion': f'El mes más activo fue {nombre_mes(mes_activo)} con {int(por_mes.max())} sismos; '
                        f'el más tranquilo, {nombre_mes(mes_tranquilo)} con {int(por_mes.min())}.'},
        {'archivo': 'grafica2_histograma_magnitud.png', 'titulo': 'Distribución de las magnitudes',
         'descripcion': f'La magnitud promedio fue {numero(promedio, 2)}: los sismos pequeños son '
                        'mucho más frecuentes que los grandes.'},
        {'archivo': 'grafica3_profundidad_magnitud.png', 'titulo': 'Profundidad vs magnitud',
         'descripcion': f'Correlación r = {numero(correlacion, 2)}: {relacion}.'},
        {'archivo': 'grafica4_mapa_epicentros.png', 'titulo': 'Mapa de epicentros',
         'descripcion': 'Cada punto es un sismo ubicado por su longitud y latitud; los puntos grandes son '
                        'los de mayor magnitud y el color indica la profundidad.'},
        {'archivo': 'grafica5_profundidad.png', 'titulo': 'Sismos según la profundidad',
         'descripcion': f'{superficiales} de {len(datos)} sismos ({numero(pct_superficiales, 0)} %) '
                        'fueron superficiales, a menos de 70 km.'},
        {'archivo': 'grafica6_zonas.png', 'titulo': 'Zonas con más sismos',
         'descripcion': f'La zona con más registros fue {zona_activa} con {int(top.iloc[-1])} sismos.'},
    ],
}

resumen['texto'] = (
    f"Entre el {fecha_larga(datos['fecha'].min())} y el {fecha_larga(datos['fecha'].max())} "
    f"se registraron {len(datos)} sismos en {region}, con una magnitud promedio de "
    f"{numero(promedio, 2)} y una profundidad promedio de {numero(resumen['profundidad_media'])} km. "
    f"El más fuerte fue de magnitud {numero(mayor['magnitud'])} el {fecha_larga(mayor['fecha'])} "
    f"({mayor['lugar']}). {fuertes} sismos alcanzaron magnitud 5 o más. "
    f"{nombre_mes(mes_activo).capitalize()} fue el mes más activo ({int(por_mes.max())} sismos) y "
    f"{zona_activa} la zona con más registros. "
    f"El {numero(pct_superficiales, 0)} % de los sismos fueron superficiales y {relacion}."
)

with open(os.path.join(carpeta, 'resumen.json'), 'w', encoding='utf-8') as salida:
    json.dump(resumen, salida, ensure_ascii=False, indent=2)

print('OK')
