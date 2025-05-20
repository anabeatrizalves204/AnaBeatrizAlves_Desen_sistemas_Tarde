from selenium import webdriver;
from selenium.webdriver.common.by import By;
import time;

# Configuração do webdriver (nesse exemplo, estamos usando o chrome)
driver = webdriver.Chrome()

# Acessa a página de cadastro usando o caminho absoluto
# Com o protocolo file ://
# Certifique-se de que o caminho está apontando 