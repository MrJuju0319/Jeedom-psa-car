#!/bin/bash

# Activer l'environnement virtuel Python du plugin
VENV_PATH="/var/www/html/plugins/psacar/resources/python_venv"
if [ -d "$VENV_PATH" ]; then
    echo "Activation de l'environnement virtuel Python..."
    source "$VENV_PATH/bin/activate"
else
    echo "[ERROR] Environnement virtuel introuvable : $VENV_PATH"
    exit 1
fi

# Désinstaller les versions incompatibles de urllib3 et requests
echo "Désinstallation des versions incompatibles de urllib3 et requests..."
pip uninstall -y urllib3 requests

# Installer les versions compatibles
echo "Installation des versions compatibles de urllib3 et requests..."
pip install "urllib3<2.0.0,>=1.15.1" "requests<2.28.0"

# Réinstaller psa-car-controller pour s'assurer qu'il est correctement configuré
echo "Réinstallation de psa-car-controller..."
pip install --force-reinstall psa-car-controller

# Désactiver l'environnement virtuel
echo "Désactivation de l'environnement virtuel Python..."
deactivate

echo "Résolution du conflit de dépendances terminée."
exit 0
