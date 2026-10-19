# =============================================================================
# Soluciones de los ejercicios para el estudiante
# Ejecutar: python ejercicios_soluciones.py
# =============================================================================

import pandas as pd
import matplotlib.pyplot as plt

df = pd.read_csv("ventas.csv")
df["Ganancia"] = df["Ventas"] - df["Costos"]

orden = ["Enero", "Febrero", "Marzo", "Abril"]

# -----------------------------------------------------------------------------
# Ejercicio 1: Columna "Ganancia" graficada por mes
# -----------------------------------------------------------------------------
ganancia_por_mes = df.groupby("Mes")["Ganancia"].sum().reindex(orden)

plt.figure(figsize=(8, 5))
plt.bar(ganancia_por_mes.index, ganancia_por_mes.values, color="seagreen")
plt.title("Ganancia por Mes", fontsize=14, fontweight="bold")
plt.xlabel("Mes")
plt.ylabel("Ganancia ($)")
plt.tight_layout()
plt.savefig("ejercicio_ganancia.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# Ejercicio 2: Grafico de barras horizontal (barh)
# -----------------------------------------------------------------------------
ventas_producto = df.groupby("Producto")["Ventas"].sum()

plt.figure(figsize=(8, 5))
colores = ["#4C72B0", "#DD8452", "#55A868"]
plt.barh(ventas_producto.index, ventas_producto.values, color=colores)
plt.title("Ventas Totales por Producto (horizontal)", fontsize=14, fontweight="bold")
plt.xlabel("Ventas ($)")
plt.ylabel("Producto")
plt.tight_layout()
plt.savefig("ejercicio_barras_horizontal.png", dpi=150)
plt.show()

# -----------------------------------------------------------------------------
# Ejercicio 3: Exportar resumen a resumen.csv
# -----------------------------------------------------------------------------
ventas_producto.to_csv("resumen.csv", header=["Ventas_Total"])
print("Archivo resumen.csv generado")

# -----------------------------------------------------------------------------
# Ejercicio 4: Lineas con dos series (Ventas y Costos)
# -----------------------------------------------------------------------------
ventas_mes = df.groupby("Mes")["Ventas"].sum().reindex(orden)
costos_mes = df.groupby("Mes")["Costos"].sum().reindex(orden)

plt.figure(figsize=(8, 5))
plt.plot(ventas_mes.index, ventas_mes.values, marker="o",
         label="Ventas", color="steelblue")
plt.plot(costos_mes.index, costos_mes.values, marker="s",
         label="Costos", color="crimson")
plt.title("Ventas vs. Costos por Mes", fontweight="bold")
plt.xlabel("Mes")
plt.ylabel("Monto ($)")
plt.legend()
plt.grid(alpha=0.4)
plt.tight_layout()
plt.savefig("ventas_costos.png", dpi=150)
plt.show()
