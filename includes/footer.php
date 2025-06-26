<!-- Rodapé do site -->
<footer class="mt-auto py-3">
    <div class="container text-center">
        <p class="mb-0">© <?= date('Y'); ?> PICAPS - Fiocruz</p>
        <p class="mb-0">Caderno Agroecológico & Solidário</p>
    </div>
</footer>

<!-- Inclui o JavaScript do Bootstrap (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> </script>

<script>
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

        let soma = 0;
        for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
        let resto = 11 - (soma % 11);
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
        resto = 11 - (soma % 11);
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const cpf = document.querySelector('[name="cpf"]').value;
        if (!validarCPF(cpf)) {
            alert('CPF inválido!');
            e.preventDefault();
        }
    });

    // Máscara simples de CPF e telefone
    document.querySelector('[name="cpf"]').addEventListener('input', function(e) {
        e.target.value = e.target.value
            .replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    });

    document.querySelector('[name="telefone"]').addEventListener('input', function(e) {
        e.target.value = e.target.value
            .replace(/\D/g, '')
            .replace(/(\d{2})(\d)/, '($1) $2')
            .replace(/(\d{5})(\d{1,4})$/, '$1-$2');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/relatorios.js"></script>

</body>

</html>