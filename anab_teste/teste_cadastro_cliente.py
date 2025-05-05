from selenium import webdriver
from selenium.webdriver.common.by import By
import time

# Configuração do webdriver (nesse exemplo, estamos usando o Chrome)
driver = webdriver.Chrome()

# Acessa a página de cadastro usando o caminho absoluto com o protocolo file://
# Certifique-se de que o caminho está apontando para um arquivo HTML específico
driver.get("file:///C:/Users/ana_alves7/Documents/GitHub/AnaBeatrizAlves_Desen_sistemas_Tarde/anab_teste/index.html")

# Preencha o campo Nome 
nome_input = driver.find_element(By.ID, "name")
nome_input.send_keys("João da Silva")

# Preencha o campo CPF
cpf_input = driver.find_element(By.ID, "cpf")
cpf_input.send_keys("12345678901")

# Preencha  campo Endereço
endereco_input = driver.find_element(By.ID, "address")
endereco_input.send_keys("Rua das Flores, 123")

#Preencha o campo Telefone
telefone_input = driver.find_element(By.ID, "phone")
telefone_input.send_keys("11987654321")

# Clica no botão cadastrar 
submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']" )
submit_button.click()

#Aguarda um momento para visualizar o resultado (em uma aplicação real)
time.sleep(8)

# Fecha um navegador
driver.quit()