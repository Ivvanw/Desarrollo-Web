# =============================================================================
# Clase: Lectura de CSV con pandas y graficos con matplotlib
# Archivo: ventas.csv (Mes, Producto, Ventas, Costos)
# Ejecutar: python graficos_csv.py
# Requisitos: pip install pandas matplotlib numpy
# =============================================================================

import pandas as pd
import matplotlib.pyplot as plt
import numpy as np

# -----------------------------------------------------------------------------
# 3. Leer el archivo CSV paso a paso
# -----------------------------------------------------------------------------
df = pd.read_csv("ventas.csv")

print("Primeras filas:")
print(df.head())

print("\nInformacion del DataFrame:")
print(df.info())

print("\nEstadisticas:")
print(df.describe())

# Ejemplo con parametros de pd.read_csv
# df = pd.read_csv("ventas.csv",
#                  sep=",",
#                  encoding="utf-8",
#                  usecols=["Mes", "Producto", "Ventas"])

# Grafico de barras agrupadas con pivot
tabla = df.pivot(
    index="Mes",
    columns="Producto",
    values="Ventas"
)

orden_meses = ["Enero", "Febrero", "Marzo", "Abril"]
tabla = tabla.reindex(orden_meses)

tabla.plot(kind="bar", figsize=(10, 6))
plt.title("Ventas por producto y mes")
plt.xlabel("Mes")
plt.ylabel("Ventas ($)")
plt.xticks(rotation=0)
plt.legend(title="Producto")
plt.grid(axis="y", linestyle="--", alpha=0.5)
plt.tight_layout()
plt.savefig("grafico_barras_agrupadas.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 4. Exploracion y limpieza de datos
# -----------------------------------------------------------------------------
print("\nValores nulos por columna:")
print(df.isnull().sum())

df = df.dropna()

print("\nTipos de datos:")
print(df.dtypes)

print("\nProductos unicos:", df["Producto"].unique())
print("Meses unicos:", df["Mes"].unique())

# Columna calculada
df["Ganancia"] = df["Ventas"] - df["Costos"]
print("\nDataFrame con Ganancia:")
print(df.head())

# -----------------------------------------------------------------------------
# 5. Grafico de lineas - Evolucion mensual
# -----------------------------------------------------------------------------
orden = ["Enero", "Febrero", "Marzo", "Abril"]
ventas_por_mes = df.groupby("Mes")["Ventas"].sum().reindex(orden)

plt.figure(figsize=(8, 5))
plt.plot(ventas_por_mes.index, ventas_por_mes.values,
         marker="o", color="steelblue", linewidth=2)

plt.title("Evolucion de Ventas por Mes", fontsize=14, fontweight="bold")
plt.xlabel("Mes")
plt.ylabel("Ventas ($)")
plt.grid(True, linestyle="--", alpha=0.6)
plt.tight_layout()
plt.savefig("grafico_lineas.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 6. Grafico de barras - Comparacion por producto
# -----------------------------------------------------------------------------
ventas_producto = df.groupby("Producto")["Ventas"].sum()

plt.figure(figsize=(8, 5))
colores = ["#4C72B0", "#DD8452", "#55A868"]

plt.bar(ventas_producto.index, ventas_producto.values, color=colores)

plt.title("Ventas Totales por Producto", fontsize=14, fontweight="bold")
plt.xlabel("Producto")
plt.ylabel("Ventas ($)")

for i, valor in enumerate(ventas_producto.values):
    plt.text(i, valor + 300, f"${valor:,}", ha="center", fontsize=10)

plt.tight_layout()
plt.savefig("grafico_barras.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 7. Grafico de torta - Participacion de cada producto
# -----------------------------------------------------------------------------
plt.figure(figsize=(7, 7))
plt.pie(ventas_producto.values,
        labels=ventas_producto.index,
        autopct="%1.1f%%",
        colors=colores,
        startangle=90,
        explode=(0.05, 0, 0))

plt.title("Participacion de Ventas por Producto",
          fontsize=14, fontweight="bold")
plt.tight_layout()
plt.savefig("grafico_torta.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 8. Histograma - Distribucion de ventas
# -----------------------------------------------------------------------------
plt.figure(figsize=(8, 5))
plt.hist(df["Ventas"], bins=6, color="mediumseagreen",
         edgecolor="black", alpha=0.8)

plt.title("Distribucion de Ventas", fontsize=14, fontweight="bold")
plt.xlabel("Rango de ventas ($)")
plt.ylabel("Frecuencia")
plt.grid(axis="y", linestyle="--", alpha=0.6)

plt.tight_layout()
plt.savefig("histograma_ventas.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 9. Grafico de dispersion - Ventas vs. Costos
# -----------------------------------------------------------------------------
plt.figure(figsize=(8, 5))
plt.scatter(df["Costos"], df["Ventas"],
            c="crimson", s=100, alpha=0.7, edgecolors="black")

plt.title("Relacion Ventas vs. Costos", fontsize=14, fontweight="bold")
plt.xlabel("Costos ($)")
plt.ylabel("Ventas ($)")
plt.grid(True, linestyle="--", alpha=0.5)

z = np.polyfit(df["Costos"], df["Ventas"], 1)
p = np.poly1d(z)
plt.plot(df["Costos"], p(df["Costos"]), "b--",
         label=f"Tendencia: y = {z[0]:.2f}x + {z[1]:.0f}")
plt.legend()

plt.tight_layout()
plt.savefig("grafico_dispersion.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# 10. Combinar varios graficos en una figura (panel 2x2)
# -----------------------------------------------------------------------------
fig, axes = plt.subplots(2, 2, figsize=(12, 9))

axes[0, 0].plot(ventas_por_mes.index, ventas_por_mes.values,
                marker="o", color="steelblue")
axes[0, 0].set_title("Ventas por Mes")
axes[0, 0].grid(True, alpha=0.4)

axes[0, 1].bar(ventas_producto.index, ventas_producto.values, color=colores)
axes[0, 1].set_title("Ventas por Producto")

axes[1, 0].pie(ventas_producto.values, labels=ventas_producto.index,
               autopct="%1.1f%%", colors=colores)
axes[1, 0].set_title("Participacion")

axes[1, 1].scatter(df["Costos"], df["Ventas"], c="crimson", s=80, alpha=0.7)
axes[1, 1].set_title("Ventas vs. Costos")
axes[1, 1].set_xlabel("Costos")
axes[1, 1].set_ylabel("Ventas")

plt.suptitle("Panel de Analisis de Ventas", fontsize=16, fontweight="bold")
plt.tight_layout()
plt.savefig("panel_ventas.png", dpi=150)
plt.show()

print("\nGraficos generados correctamente.")
