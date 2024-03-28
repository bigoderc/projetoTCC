
async function alert(title, text) {

    Swal.isVisible() && Swal.close();

    await Swal.fire({
        customClass: {
            container: "",
            popup: "",
            header: "",
            title: "",
            closeButton: "",
            icon: "",
            image: "",
            content: "",
            htmlContainer: "",
            input: "",
            inputLabel: "",
            validationMessage: "",
            actions: "",
            confirmButton: "bg-primary",
            denyButton: "",
            cancelButton: "bg-primary",
            loader: "",
            footer: "",
            timerProgressBar: "",
        },
        allowOutsideClick: true,
        showCancelButton: true,
        showConfirmButton: true,
        title: title,
        text: text,
    });
}
async function toast(icon, title, text) {

    Swal.isVisible() && Swal.close();

    await Swal.fire({
        customClass: {
            container: "",
            popup: "",
            header: "",
            title: "lh-base",
            closeButton: "",
            icon: "",
            image: "",
            content: "",
            htmlContainer: "",
            input: "",
            inputLabel: "",
            validationMessage: "",
            actions: "",
            confirmButton: "",
            denyButton: "",
            cancelButton: "",
            loader: "",
            footer: "",
            timerProgressBar: "",
        },
        toast: true,
        position: 'bottom-right',
        showCancelButton: false,
        showConfirmButton: false,
        icon: icon,
        title: title,
        text: text,
        didOpen: () => {
            document.querySelector("#app").addEventListener("click", function () {
                Swal.close();
            }, { once: true });
        }
    });
}
function successResponse() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Swal.isVisible() && Swal.close();

    Toast.fire({
        icon: 'success',
        title: 'Sucesso'
    });
}
function clearForm(formId,modalId) {
    // Obtém o formulário pelo ID
    var form = document.getElementById(formId);

    // Limpa todos os campos do formulário
    for (var i = 0; i < form.elements.length; i++) {
        var element = form.elements[i];

        // Limpa apenas os campos de input, textarea e select
        if (element.type !== 'button' && element.type !== 'submit' && element.type !== 'reset' && element.type !== 'hidden') {
            element.value = '';
        }
    }
    $(`#${modalId}`).modal('hide');
    $(`#titulo`).text(`Adicionar`);
    $(`#salvar`).text(`Adicionar`);
    $(`#email`).prop('disabled', false);
}

function errorResponse(status,data,text) {
    var msg = '';
    switch (status) {
        
        case 422:
            var data = data;
            
            // Verificando se há propriedades no objeto "data"
            if (data) {
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                    var value = data[key];
                    msg += key + ": " + value
                    }
                }
            }
            
            // Trate o erro de validação conforme necessário
            break;
        case 500:
            msg = 'Erro interno do servidor';
            // Trate o erro interno do servidor conforme necessário
            break;
        default:
            msg = 'Erro desconhecido';
            
            break;
    }
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Swal.isVisible() && Swal.close();
    msg = decodeURIComponent(JSON.parse('"' + msg + '"'));;
    Toast.fire({
        icon: 'error',
        title: `${msg}`
    });
}
function deleteAlert() {

    Swal.isVisible() && Swal.close();

    return Swal.fire({
        title: 'Tem certeza?',
        text: "Você talvez não seja capaz de reverter isso.",
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn btn-secondary text-white mr-1',
            cancelButton: 'btn btn-secondary text-white',
        },
        buttonsStyling: false,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
        focusCancel: true
    });

}
async function confirmAlert(string) {

    Swal.isVisible() && Swal.close();

    return Swal.fire({
        title: `${string}`,
        text: "Você talvez não seja capaz de reverter isso.",
        showCancelButton: true,
        customClass: {
            confirmButton: 'btn btn-secondary text-white me-2',
            cancelButton: 'btn btn-secondary text-white '
        },
        buttonsStyling: false,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
        focusCancel: true

    })
}

function responseError(response) {
    const status = response.status;
    const data = response.data?.data;

    switch (status) {
        case 500:
            return 'Houve um erro inesperado.';
        case 403:
            return 'Usuário não possui permissão.';
        case 423:
            return 'Parcela não possui data de baixa.';
        default:
            if (data) {
                return Object.values(data).map((v) => `<div>${v}</div>`).join('');
            } else {
                return response.data?.message || 'Ocorreu um erro desconhecido. Por favor, entre em contato com o suporte.';
            }
    }
}

async function justifyAlert() {

    Swal.isVisible() && Swal.close();

    return Swal.fire({
        title: 'Justificativa',
        showCancelButton: true,
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
            required: true,
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Você precisa informar uma justificativa!'
            }
        },
        customClass: {
            confirmButton: 'btn btn-secondary text-white me-2',
            cancelButton: 'btn btn-secondary text-white '
        },
        buttonsStyling: false,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar',
        focusCancel: true
    })
}
async function notification(icon, title, text) {

    Swal.isVisible() && Swal.close();

    return Swal.fire({
        customClass: {
            title: "fs-6",
            htmlContainer: "fs-6",
            confirmButton: 'btn btn-secondary mx-1',
            cancelButton: 'btn btn-gold mx-1 text-white'
        },
        position: 'bottom-right',
        icon: icon,
        title: title,
        text: text,       
        buttonsStyling: false,
        reverseButtons: false,
        showConfirmButton: true,
        confirmButtonText: 'Acessar Temas',
        showCancelButton: true,
        cancelButtonText: 'Fechar',
        toast: true,
        
    });
}
