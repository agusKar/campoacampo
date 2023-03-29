// Cargar datos al iniciar la APP
window.addEventListener("load", () => {
  renderProducts()
});

// Muestra el modal
const showModal = () => {
  let modal = document.querySelector(".modal");
  modal.classList.add("show")
}

// Cierra el modal
const closeModal = () => {
  let modal = document.querySelector(".modal");
  modal.classList.remove("show")
}
// Tomo el form para el evento SUBMIT
let formProduct = document.querySelector("form");
formProduct.addEventListener("submit", (e) => {
  e.preventDefault()
  let nombre = document.querySelector("#nombre").value;
  let precio = Number(document.querySelector("#precio").value);
  getDataPost(nombre, precio)
  formProduct.reset()
})

// Tomo el botton borrar
const deleteProduct = async (id) => {
  try {
    const data = await fetch("http://localhost/campoacampo/back/", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id }),
    });
    renderProducts();
  } catch (error) {
    console.log(error);
  }
}

// Crear nuevo producto
const getDataPost = async (nombre, precio) => {
  try {
    const data = await fetch("http://localhost/campoacampo/back/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ nombre, precio }),
    });
    // const result = await data.json();

    let alert = document.querySelector("#alertProducto");
    alert.classList.remove("d-none")
    alert.innerHTML = "Producto creado"
    setTimeout(() => {
      alert.classList.add("d-none")
      alert.innerHTML = ""
    }, 2000)
    renderProducts();
    // return result;
  } catch (error) {
    console.log(error);
  }
};

// Traer todos los productos
const getDataGet = async () => {
  try {
    const data = await fetch("http://localhost/campoacampo/back/");
    return await data.json();
  } catch (error) {
    console.log(error);
  }
};

// Renderiza los productos en la tabla
const renderProducts = async () => {
  let products = await getDataGet();
  let html = "";
  if (products.length > 0) {
    let priceDolar = Number(document.querySelector(".alert.price_dolar span").innerHTML)
    products.forEach((product) => {
      let htmlSegment = `<tr><td>${product.id}</td><td>${product.nombre}</td><td>${product.precio}</td><td>${(product.precio / priceDolar).toFixed(2)}</td><td><button id="deleteProduct" onclick="deleteProduct(${product.id})" class="danger">X</button></td></tr>`;

      html += htmlSegment;
    });
  } else {
    html = '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
  }

  let table = document.querySelector("table#tableProducts tbody");
  table.innerHTML = html;
}