const orderNumber = JSON.parse(localStorage.getItem("number")) + 1;
localStorage.setItem("number", JSON.stringify(orderNumber));
export const orderContent = [];
export const orderContentMenu = [];
localStorage.setItem
const typeOrder = new URLSearchParams(window.location.search);
const order = document.getElementById("order");
let result = 0;
let buttonPay;



export const updateOrder = () => {
  const listMenus = orderContentMenu.map((item, index) => {
    const supplementsList = item.supplements.map(supplement => {
      return (
        `
        <li>${supplement}</li>
        `
      )
    })
    // Ici je sépare le prix et la poubelle du h4 car, sur petit écran, ça se mettait entre le nom et les suppléments.
    // Le data index pour savoir quel élément supprimer et le data type pour savoir si je dois supprimer dans les menus ou l'autre tableau.
    return (
      `<div class="borderOrder">
        <h4>${item.name}</h4>
        <ul>${supplementsList.join("")}</ul>
        <div class="price-trash">${item.price} €<figure><img class="trashs" data-type="menus" data-index =${index} src="../../../img/images/trash.png" alt="trash"></figure></div>
      </div>
      
      `
    )
  })

  const list = orderContent.map((item, index) => {
    return (
      `
      <h4 class="borderOrder"><p>${item.quantity}x ${item.name}</p><span class="price-trash">${item.price}€<figure><img class="trashs" data-type="noMenus" data-index =${index} src="../../../img/images/trash.png" alt="trash"></figure></span></h4>
      `
    )
  })

  order.innerHTML = `
      <header>
        <figure id="logo">
          <img src="../../../img/images/logo.png" alt="logo" />
        </figure>
        <p>Commande n° <span class="fatAndBold">${orderNumber}</span></p>
        <p>${typeOrder.get("type") === "eatIn" ? "Sur place" : "À emporter"}</p>
      </header>
      <div id="listContent">
        <div>${listMenus.join("")} ${list.join("")}</div>
        <footer>
          <p>TOTAL (ttc) <span class="fatAndBold">${Math.round(result * 100) / 100} €</span></p>
          <div id="buttons">
            <button><a href="../index.html">Abandon</a></button>
            <button id="pay">Payer</button>
          </div>
        </footer>
      </div>
      
    `
  order.querySelectorAll(".trashs").forEach(trash => {
    trash.addEventListener("click", (e) => {
      const index = e.target.dataset.index;
      const type = e.target.dataset.type;
      if (type === "menus") {
        const deletedItem = orderContentMenu.splice(index, 1)
        substractFromResult(Number(deletedItem[0].price))
      } else if (type === "noMenus") {
        // Pour ne supprimer qu'une quantité plutôt que toute la ligne, rajouter une caractéristique "prix unitaire" à la création, ne jamais y toucher et la récupérer pour diminuer le prix en même temps que la quantité.
        const deletedItem = orderContent.splice(index, 1);
        substractFromResult(Number(deletedItem[0].price))
      }
      updateOrder()
    })
  })

  let orderChoices = orderContent.map(choice => {
    return { name: choice.name, quantity: choice.quantity }
  });
  orderChoices = [...orderChoices, ...orderContentMenu.flatMap(choice => {
    return choice.supplements.map(item => {
      if (choice.name.toLowerCase().includes("maxi")) {
        return { name: item, xxl: true, quantity: "1" }
      } else {
        return { name: item, quantity: "1" }
      }
    })
  })];

  const finalOrder = {

    result,
    orderNumber,
    orderChoices

  };
  order.querySelector("#pay").addEventListener("click", () => {
    localStorage.setItem("order", JSON.stringify(finalOrder))
    window.location.href = "./paiement.html"
  })
  buttonPay = document.querySelector("#pay");
  buttonPay.disabled = (result === 0);
}

updateOrder();
export const addToResult = (price, number = 1) => {
  // const firstOperation = (Math.floor(Number(price) * 100)) * number / 100;
  // result += Number(firstOperation.toFixed(2))

  //Seul moyen de réussir à avoir les bons résultats. Le math.floor ne suffisait pas pour les multiples de 3. J'avais plein de chiffres après la virgule.
  const convertCents = Math.round(Number(price) * 100);
  const total = convertCents * number;
  result = Math.round((result * 100) + total) / 100;
  
};

export const substractFromResult = (price) => {
  result = Math.max(Math.floor((result - Number(price)) * 100) / 100, 0);
  
}