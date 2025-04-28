function validarFormulario() {
    const nome = document.getElementById("nome").value.trim();
    const nascimento = document.getElementById("nascimento").value;
    const email = document.getElementById("email").value.trim();
    const telefone = document.getElementById("telefone").value.trim();

    if (!nome || !nascimento || !email || !telefone) {
      alert("Por favor, preencha todos os campos.");
      return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Digite um e-mail válido.");
      return false;
    }

    const telefoneRegex = /^\d{10,11}$/; // Exemplo para números brasileiros sem DDD formatado
    if (!telefoneRegex.test(telefone)) {
      alert("Digite um número de telefone válido (apenas números).");
      return false;
    }

    alert("Cadastro enviado com sucesso!");
    return true;
  }