"""
Genera el reporte de sismos en PDF con fpdf.

Uso:  python reporte_pdf.py <carpeta> <usuario> "<AAAA-MM-DD HH:MM>" <archivo_csv> <salida.pdf>

Toma el resumen.json y las gráficas que dejó analisis_sismos.py en <carpeta>.
"""
import json
import os
import sys

from fpdf import FPDF

carpeta, usuario, fecha_reporte, archivo_csv, salida = sys.argv[1:6]

with open(os.path.join(carpeta, 'resumen.json'), encoding='utf-8') as entrada:
    resumen = json.load(entrada)

MESES = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
         'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']

# Paleta de la página (RGB)
AZUL_OSCURO = (30, 34, 72)
AZUL = (90, 98, 214)
NARANJA = (90, 98, 214)
TEXTO = (30, 39, 51)
TEXTO_SUAVE = (107, 118, 132)
BORDE = (227, 231, 237)
FONDO = (244, 246, 249)

ANCHO_PAGINA = 215.9
MARGEN = 18
ANCHO_UTIL = ANCHO_PAGINA - 2 * MARGEN


def fecha_larga(iso):
    anio, mes, dia = iso.split('-')
    return f'{int(dia)} de {MESES[int(mes) - 1]} de {anio}'


def numero(valor, decimales=1):
    texto = f'{valor:,.{decimales}f}'
    return texto.replace(',', '_').replace('.', ',').replace('_', '.')


TITULO = 'Reporte de sismos'
REGION = resumen.get('region', 'Colombia y alrededores')

fecha, hora = fecha_reporte.split(' ')
fecha_reporte = f'{fecha_larga(fecha)}, {hora}'


class Reporte(FPDF):
    def header(self):
        # Desde la segunda página: encabezado discreto
        if self.page_no() > 1:
            self.set_font('Helvetica', 'B', 9)
            self.set_text_color(*AZUL_OSCURO)
            self.set_xy(MARGEN, 10)
            self.cell(ANCHO_UTIL / 2, 6, TITULO)
            self.set_font('Helvetica', '', 9)
            self.set_text_color(*TEXTO_SUAVE)
            self.cell(ANCHO_UTIL / 2, 6, fecha_reporte, align='R')
            self.set_draw_color(*BORDE)
            self.line(MARGEN, 17, ANCHO_PAGINA - MARGEN, 17)
            self.set_y(24)

    def footer(self):
        self.set_y(-14)
        self.set_draw_color(*BORDE)
        self.line(MARGEN, self.get_y() - 2, ANCHO_PAGINA - MARGEN, self.get_y() - 2)
        self.set_font('Helvetica', '', 8)
        self.set_text_color(*TEXTO_SUAVE)
        self.set_x(MARGEN)
        self.cell(ANCHO_UTIL / 2, 6, 'Fuente: USGS · Procesado con pandas, matplotlib y fpdf')
        self.cell(ANCHO_UTIL / 2, 6, f'Página {self.page_no()} de {{nb}}', align='R')


def titulo_seccion(pdf, texto):
    pdf.set_x(MARGEN)
    pdf.set_font('Helvetica', 'B', 12)
    pdf.set_text_color(*AZUL_OSCURO)
    pdf.cell(ANCHO_UTIL, 7, texto, ln=1)
    pdf.set_fill_color(*NARANJA)
    pdf.rect(MARGEN, pdf.get_y(), 14, 0.8, 'F')
    pdf.ln(4)


LIMITE_INFERIOR = 279.4 - 18  # por encima del pie de página


def figura(pdf, numero_figura, grafica):
    # Las imágenes son 9 x 4.5 pulgadas: alto = ancho / 2.
    # Si no cabe completa (se reservan 14 mm para el pie de figura), se reduce centrada.
    y = pdf.get_y()
    alto = min(ANCHO_UTIL / 2, LIMITE_INFERIOR - y - 14)
    ancho = alto * 2
    pdf.image(os.path.join(carpeta, grafica['archivo']), x=MARGEN + (ANCHO_UTIL - ancho) / 2,
              y=y, w=ancho, h=alto)
    pdf.set_xy(MARGEN, y + alto + 1)
    pdf.set_font('Helvetica', 'B', 9)
    pdf.set_text_color(*TEXTO)
    pdf.cell(ANCHO_UTIL, 5, f"Figura {numero_figura}. {grafica['titulo']}", ln=1)
    pdf.set_x(MARGEN)
    pdf.set_font('Helvetica', '', 9)
    pdf.set_text_color(*TEXTO_SUAVE)
    pdf.multi_cell(ANCHO_UTIL, 4.5, grafica['descripcion'], align='L')
    pdf.ln(6)


pdf = Reporte(orientation='P', unit='mm', format='Letter')
pdf.alias_nb_pages()
pdf.set_auto_page_break(auto=False)
pdf.set_margins(MARGEN, MARGEN, MARGEN)
pdf.set_title(TITULO)
pdf.set_author(usuario)
pdf.add_page()

# ------------------------------------------------------------------
# Portada: franja azul con título y subtítulo
# ------------------------------------------------------------------
pdf.set_fill_color(*AZUL_OSCURO)
pdf.rect(0, 0, ANCHO_PAGINA, 46, 'F')
pdf.set_fill_color(*NARANJA)
pdf.rect(0, 46, ANCHO_PAGINA, 1.2, 'F')

pdf.set_xy(MARGEN, 12)
pdf.set_font('Helvetica', 'B', 8)
pdf.set_text_color(184, 189, 255)
pdf.cell(ANCHO_UTIL, 5, 'SISTEMA DE INFORMACIÓN SÍSMICA', ln=1)
pdf.set_x(MARGEN)
pdf.set_font('Helvetica', 'B', 22)
pdf.set_text_color(255, 255, 255)
pdf.cell(ANCHO_UTIL, 11, TITULO, ln=1)
pdf.set_x(MARGEN)
pdf.set_font('Helvetica', '', 10.5)
pdf.set_text_color(214, 224, 235)
pdf.cell(ANCHO_UTIL, 7, f"{REGION[0].upper() + REGION[1:]}: sismos del {fecha_larga(resumen['fecha_inicio'])} "
                        f"al {fecha_larga(resumen['fecha_fin'])}", ln=1)

# Datos del reporte en dos columnas
datos_reporte = [
    ('Fecha del reporte', fecha_reporte),
    ('Elaborado por', usuario),
    ('Archivo analizado', archivo_csv),
    ('Registros', f"{resumen['total']} sismos"),
]
y = 56
for indice, (etiqueta, valor) in enumerate(datos_reporte):
    x = MARGEN + (indice % 2) * (ANCHO_UTIL / 2)
    fila = y + (indice // 2) * 13
    pdf.set_xy(x, fila)
    pdf.set_font('Helvetica', '', 8)
    pdf.set_text_color(*TEXTO_SUAVE)
    pdf.cell(ANCHO_UTIL / 2, 4, etiqueta.upper(), ln=2)
    pdf.set_font('Helvetica', 'B', 10.5)
    pdf.set_text_color(*TEXTO)
    pdf.cell(ANCHO_UTIL / 2, 6, valor)

# ------------------------------------------------------------------
# Indicadores
# ------------------------------------------------------------------
indicadores = [
    (str(resumen['total']), f"Sismos ({resumen['fuertes']} de magnitud 5+)"),
    (f"M {numero(resumen['magnitud_max'])}", f"Mayor · {fecha_larga(resumen['magnitud_max_fecha'])}"),
    (numero(resumen['magnitud_media'], 2), 'Magnitud promedio'),
    (resumen['mes_activo'].capitalize(), f"Mes más activo ({resumen['mes_activo_sismos']} sismos)"),
]
separacion = 4
ancho_caja = (ANCHO_UTIL - separacion * 3) / 4
y = 86
for indice, (valor, nombre) in enumerate(indicadores):
    x = MARGEN + indice * (ancho_caja + separacion)
    pdf.set_fill_color(*FONDO)
    pdf.set_draw_color(*BORDE)
    pdf.rect(x, y, ancho_caja, 24, 'DF')
    pdf.set_fill_color(*NARANJA)
    pdf.rect(x, y, ancho_caja, 1, 'F')
    pdf.set_xy(x + 3, y + 5)
    pdf.set_font('Helvetica', 'B', 12 if len(valor) < 12 else 10)
    pdf.set_text_color(*AZUL_OSCURO)
    pdf.cell(ancho_caja - 6, 7, valor, ln=2)
    pdf.set_font('Helvetica', '', 7.5)
    pdf.set_text_color(*TEXTO_SUAVE)
    pdf.multi_cell(ancho_caja - 6, 3.6, nombre, align='L')

# ------------------------------------------------------------------
# Resumen y primera gráfica
# ------------------------------------------------------------------
pdf.set_y(120)
titulo_seccion(pdf, 'Resumen')
pdf.set_x(MARGEN)
pdf.set_font('Helvetica', '', 10)
pdf.set_text_color(*TEXTO)
pdf.multi_cell(ANCHO_UTIL, 5.4, resumen['texto'])
pdf.ln(5)

titulo_seccion(pdf, 'Gráficas')
graficas = resumen['graficas']
figura(pdf, 1, graficas[0])

# Resto de gráficas: dos por página
for indice in range(1, len(graficas), 2):
    pdf.add_page()
    for numero_figura in range(indice, min(indice + 2, len(graficas))):
        figura(pdf, numero_figura + 1, graficas[numero_figura])

# ------------------------------------------------------------------
# Tabla de resumen por mes (en el espacio libre de la última página)
# ------------------------------------------------------------------
columnas = [('Mes', 58, 'L'), ('Sismos', 25, 'C'), ('Magnitud media', 32, 'R'),
            ('Magnitud máx.', 32, 'R'), ('Profundidad media', 32.9, 'R')]
alto_fila = 6.2
if pdf.get_y() + 14 + alto_fila * (len(resumen['meses']) + 1) > LIMITE_INFERIOR:
    pdf.add_page()

titulo_seccion(pdf, 'Resumen por mes')
pdf.set_x(MARGEN)
pdf.set_font('Helvetica', 'B', 8.5)
pdf.set_fill_color(*AZUL_OSCURO)
pdf.set_text_color(255, 255, 255)
for nombre, ancho, alineacion in columnas:
    pdf.cell(ancho, alto_fila + 0.8, nombre, align=alineacion, fill=True)
pdf.ln()

pdf.set_font('Helvetica', '', 8.5)
pdf.set_draw_color(*BORDE)
for indice, mes in enumerate(resumen['meses']):
    pdf.set_x(MARGEN)
    pdf.set_fill_color(*(FONDO if indice % 2 else (255, 255, 255)))
    pdf.set_text_color(*TEXTO)
    valores = [mes['mes'].capitalize(), str(mes['sismos']), numero(mes['magnitud_media'], 2),
               numero(mes['magnitud_max']), f"{numero(mes['profundidad_media'])} km"]
    for (nombre, ancho, alineacion), valor in zip(columnas, valores):
        pdf.cell(ancho, alto_fila, valor, border='B', align=alineacion, fill=True)
    pdf.ln()

pdf.output(salida)
print('OK')
