function toggleFields() {
    const tipo = document.getElementById('tipo').value;
    const clienteFields = document.getElementById('clienteFields');
    const empresaFields = document.getElementById('empresaFields');
    const formInput = document.querySelector('form .input');

        if (tipo === 'cliente') {
            clienteFields.style.display = 'block';
            clienteFields.style.height = 'auto';
            empresaFields.style.display = 'none';
            formInput.style.height = '850px';
        } else if (tipo === 'empresa') {
            clienteFields.style.display = 'none';
            empresaFields.style.display = 'block';
            formInput.style.height = '1100px';
        }
    }