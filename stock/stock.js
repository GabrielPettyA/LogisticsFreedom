const url = "../includes/api/stock-api/stock.php";
const table_body = document.getElementById("table_body");

// Edit modal
const edit_name = document.getElementById("edit_name");
const errorEditName = document.getElementById("editName_error");
const botones = document.getElementById("botones");

// Paginación 
const lastPage = document.getElementById("lastPage");
const pageActual = document.getElementById("pageActual");
const btnPrevPage = document.getElementById("btnPrevPage");
const btnNextPage = document.getElementById("btnNextPage");

// Variables de uso general
let id_select = 0; // Se guarda el id al seleccionar eliminar o editar
let product_select = {}; // Se guarda el registro del producto al seleccionar eliminar o editar
let productsData = {}; // Se guardan todos los productos
let desdeFiltrar = 0;
let hastaFiltrar = 1;

function obtenerDatos() {
    table_body.innerHTML = "";
    fetch(url + "?productos=valor")
        .then(response => response.json())
        .then(data => {
            productsData = Array.from(data);
            filterTable();
            lastPage.textContent = String(Math.ceil(productsData.length / 10));
        })
}

function filterTable() {
    table_body.innerHTML = "";
    let filterData = productsData.slice(desdeFiltrar * 10, hastaFiltrar * 10);
    pageActual.textContent = String(desdeFiltrar + 1);
    createTable(filterData);
}

function nextPage() {
    maxPage = Math.ceil(productsData.length / 10);
    proxPage = hastaFiltrar;
    if (proxPage < maxPage) {
        desdeFiltrar += 1;
        hastaFiltrar += 1;
    }
    btnPrevPage.disabled = false;
    if (proxPage >= maxPage) {
        btnNextPage.disabled = true;
    }
    filterTable();
}

function prevPage() {
    if (desdeFiltrar > 0) {
        desdeFiltrar -= 1;
        hastaFiltrar -= 1;
    }
    btnNextPage.disabled = false;
    if (desdeFiltrar <= 0) {
        btnPrevPage.disabled = true;
    }
    filterTable();
}


function createTable(products) {
    products.forEach(element => {
        let row = document.createElement("tr");
        let id = document.createElement("td");
        let product = document.createElement("td");
        let sn = document.createElement("td");
        let cant = document.createElement("td");
        let actions = document.createElement("td");

        // Acciones
        let button_edit = document.createElement("button");
        let i_edit = document.createElement("i");
        let button_delete = document.createElement("button");
        let i_delete = document.createElement("i");

        id.innerHTML = element.id;
        product.innerHTML = element.name;
        sn.innerHTML = element.sn;
        cant.innerHTML = element.cant;

        // Acciones
        button_edit.className = "btn btn-warning";
        i_edit.className = "fa-solid fa-pen-to-square";
        button_edit.addEventListener('click', () => {
            editModalShow(element);
        });

        button_delete.className = "btn btn-danger";
        i_delete.className = "fa-solid fa-trash";
        button_delete.addEventListener('click', () => {
            deleteModalShow(element);
        });

        id.style.textAlign = "center";
        product.style.textAlign = "center";
        sn.style.textAlign = "center";
        cant.style.textAlign = "center";
        actions.style.display = "flex";
        actions.style.alignContent = "center";
        actions.style.justifyContent = "space-around";

        row.appendChild(id);
        row.appendChild(product);
        row.appendChild(sn);
        row.appendChild(cant);

        // Acciones
        button_edit.appendChild(i_edit);
        actions.appendChild(button_edit);
        button_delete.appendChild(i_delete);
        actions.appendChild(button_delete);

        row.appendChild(actions);
        table_body.appendChild(row);
    });

}

function editModalShow(products) {
    var modal = new bootstrap.Modal(document.getElementById('editProduct'));
    modal.show();
    id_select = products.id;
    product_select = products;
    document.getElementById("edit_name").value = products.name;
    document.getElementById("edit_sn").value = products.sn;
    document.getElementById("edit_cant").value = products.cant;
    document.getElementById("edit_mot").value = "";
}

function deleteModalShow(products) {
    var modal = new bootstrap.Modal(document.getElementById('deleteProduct'));
    modal.show();
    id_select = products.id;
    product_select = products;
    document.getElementById("delete_id").innerHTML = products.id;
    document.getElementById("delete_name").innerHTML = products.name;
    document.getElementById("delete_sn").innerHTML = products.sn;
    document.getElementById("delete_cant").innerHTML = products.cant;
    if (product_select.cant != "0") {
        document.getElementById("delete_alert").innerHTML = "No se pueden eliminar productos con cantidades mayores a 0."
        document.getElementById("delete_button").disabled = true;
    } else {
        document.getElementById("delete_alert").innerHTML = ""
        document.getElementById("delete_button").disabled = false;
    }
}


function editProduct() {
    let editProduct = getEditFormValue(); // Producto editado para escribir la tabla de productos
    saveModifications(true); // Escritura de tabla de modificación de productos

    const requestOptions = {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(editProduct)
    };

    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            console.log(result);
            obtenerDatos();
        })
        .catch(error => {
            console.error("Error:", error);
        });
}

function getEditFormValue() {
    let editProduct = {};
    editProduct.name = document.getElementById("edit_name").value;
    editProduct.sn = document.getElementById("edit_sn").value;
    editProduct.cant = document.getElementById("edit_cant").value;
    editProduct.motivo = document.getElementById("edit_mot").value;
    editProduct.id = id_select;
    return editProduct;
}

// El validador es un valor booleano que permite hacer dinamica la función y que sirva tanto para eliminar como editar.
function saveModifications(validator) {
    let modification = {};
    let prod_old = product_select;
    modification.fecha = getDate();
    // Registro viejo
    modification.id_old = prod_old.id;
    modification.name_old = prod_old.name;
    modification.sn_old = prod_old.sn;
    modification.cant_old = prod_old.cant;

    if (validator) {
        // Registro nuevo solo en caso de que se haga desde edición
        let prod_new = getEditFormValue();
        modification.id_new = prod_new.id;
        modification.name_new = prod_new.name;
        modification.sn_new = prod_new.sn;
        modification.cant_new = prod_new.cant;
        modification.motivo = prod_new.motivo;
    } 
    
    if(!validator){
        // Registro campos nuevos en caso de borrar
        modification.id_new = 0;
        modification.name_new = "Producto eliminado";
        modification.sn_new = "Producto eliminado";
        modification.cant_new = 0;
        modification.motivo = "Eliminado";
    }

    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(modification),
    };

    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            console.log(result);
        })
        .catch(error => {
            console.error("Error:", error);
        });
}

function getDate() {
    let newDate = new Date();
    let year = newDate.getFullYear();
    let month = (newDate.getMonth() + 1).toString().padStart(2, '0');
    let day = newDate.getDate().toString().padStart(2, '0');
    let date = year + '-' + month + '-' + day;
    return date;
}

function deleteProduct() {
    let deleteReg = {};
    deleteReg.id = id_select;
    saveModifications(false);

    const requestOptions = {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(deleteReg),
    };

    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            console.log(result);
            obtenerDatos();
        })
        .catch(error => {
            console.error("Error:", error);
        });

}


/* ---------------Validaciones de campos modal eliminar editar */

function prueba() {

    let editName = edit_name.value;
    if (editName.length > 20 || editName < 3) {
        errorEditName.style.display = "block";
    } else {
        errorEditName.style.display = "none";
    }
}


obtenerDatos();
