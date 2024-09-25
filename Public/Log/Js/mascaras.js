document.addEventListener('DOMContentLoaded', () => {
    // Máscara para o campo de telefone
    const telefoneInput = document.querySelector('input[name="telefone"]');
    telefoneInput.addEventListener('input', () => {
        let value = telefoneInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
        telefoneInput.value = value
            .replace(/^(\d{2})(\d{4,5})(\d{4})$/, '($1) $2-$3')
            .replace(/(\d{2})(\d{4,5})(\d{4})/, '($1) $2-$3');
    });

    // Máscara para o campo de CNPJ
    const cnpjInput = document.querySelector('input[name="cnpj"]');
    cnpjInput.addEventListener('input', () => {
        let value = cnpjInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (value.length > 14) value = value.slice(0, 14); // Limita a 14 dígitos
        cnpjInput.value = value
            .replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5')
            .replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    });

    // Máscara para o campo de CPF
    const cpfInput = document.querySelector('input[name="cpf"]');
    cpfInput.addEventListener('input', () => {
        let value = cpfInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
        cpfInput.value = value
            .replace(/(\d{3})(\d{3})/, '$1.$2.')
            .replace(/(\d{3})(\d{2})$/, '$1-$2');
    });
});