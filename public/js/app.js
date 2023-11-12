function partialLoader2(status = true) {
    if (!status){
        swal.close();
        return;
    }

    Swal.fire({
        customClass: {
            container: "bg-white content-page",
            popup: "bg-white",
            header: "...",
            title: "...",
            closeButton: "...",
            icon: "...",
            image: "...",
            content: "...",
            htmlContainer: "...",
            input: "...",
            inputLabel: "...",
            validationMessage: "...",
            actions: "...",
            confirmButton: "...",
            denyButton: "...",
            cancelButton: "...",
            loader: "...",
            footer: "....",
            timerProgressBar: "....",
        },
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
        text: "Carregando...",
    });
}

function partialLoader(status = true) {

    if (!status){
        swal.close();
        return;
    }

    Swal.fire({
        customClass: {
            container: "content",
            popup: "bg-white",
            header: "...",
            title: "...",
            closeButton: "...",
            icon: "...",
            image: "...",
            content: "...",
            htmlContainer: "...",
            input: "...",
            inputLabel: "...",
            validationMessage: "...",
            actions: "...",
            confirmButton: "...",
            denyButton: "...",
            cancelButton: "...",
            loader: "...",
            footer: "....",
            timerProgressBar: "....",
        },
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
        text: "Carregando...",
    });
}