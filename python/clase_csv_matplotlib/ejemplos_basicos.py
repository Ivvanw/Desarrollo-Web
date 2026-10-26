# =============================================================================
# Ejemplos basicos de matplotlib (sin CSV)
# Ejecutar: python ejemplos_basicos.py
# =============================================================================

import matplotlib.pyplot as plt

# --- Ejemplo 1: Grafico de barras ---
dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"]
temperatura = [15, 16, 18, 20, 19, 17, 16]

plt.bar(dias, temperatura)
plt.xlabel("dias")
plt.ylabel("temperatura")
plt.title("Temperatura de Pasto")
plt.tight_layout()
plt.savefig("ejemplo_barras.png", dpi=150)
plt.show()

# --- Ejemplo 2: Grafico de lineas ---
tiempo_dias = [1, 2, 3, 4, 5, 6, 7]
temperatura = [15, 16, 18, 20, 19, 17, 16]

plt.plot(tiempo_dias, temperatura)
plt.xlabel("Dias")
plt.ylabel("Temperatura en grados centigrados")
plt.title("Temperatura de la ultima semana en el valle")
plt.tight_layout()
plt.savefig("ejemplo_lineas.png", dpi=150)
plt.show()

# --- Ejemplo 3: Grafico de dispersion ---
horas_estudio = [1, 2, 3, 4, 5, 6, 7, 8]
nota_examen = [3, 5, 4, 2, 1, 5, 4, 7]

plt.scatter(horas_estudio, nota_examen)
plt.xlabel("Horas de estudio")
plt.ylabel("Nota Obtenida")
plt.title("Relacion de horas")
plt.tight_layout()
plt.savefig("ejemplo_dispersion.png", dpi=150)
plt.show()
