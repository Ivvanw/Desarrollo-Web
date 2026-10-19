# =============================================================================
# Anexo A: Leer CSV sin pandas (solo stdlib)
# Ejecutar: python sin_pandas.py
# =============================================================================

import csv

with open("ventas.csv", "r", encoding="utf-8") as archivo:
    lector = csv.DictReader(archivo)

    for fila in lector:
        print(fila["Mes"], fila["Producto"], fila["Ventas"])
