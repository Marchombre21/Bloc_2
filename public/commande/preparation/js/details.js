const numberTitle = document.getElementById("numberTitle");
const list = document.getElementById("list");
const button = document.querySelector('#checked');

const getDetailsOrder = async (number) => {
    try {
        const response = await fetch(`/api.php?route=orders.php&number=${number}`);
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        alert('Impossible de récupérer les détails de la commande. Veuillez réessayer.');
        return [];
    }
 }
const params = new URLSearchParams(window.location.search);
const number = params.get("number");
let detailsOrder;

if (number) {
    detailsOrder = await getDetailsOrder(number)
}

const copyDetailsOrder = [];

detailsOrder.forEach(item => {
  const existing = copyDetailsOrder.find(el => el.product_name === item.product_name && el.xxl === item.xxl);
  if (existing) {
    existing.quantity += item.quantity;
  } else {
    copyDetailsOrder.push({ ...item });
  }
});

detailsOrder = copyDetailsOrder;

// detailsOrder.forEach((item, index) => {
//     detailsOrder.forEach((el, i) => {
//         if (item.product_name === el.product_name && item.xxl === el.xxl && index != i) {
//             detailsOrder[index].quantity += el.quantity;
//             detailsOrder.splice(i, 1);
//         }
//     })
// })

const itemsList = detailsOrder.map((item, index) => {
    return (
        `
        <tr>
              <td><input type="checkbox" class="checkbox" name="item${index}" id="item${index}"></td>
              <td><label for="item${index}">${item.product_name}</label></td>
              <td>${item.xxl === 0 ? "Normale" : "Grande"}</td>
              <td>${item.quantity}</td>
        </tr>
        `
    )
});
numberTitle.innerText = number;
list.innerHTML = itemsList.join("");
let i = 0;
document.querySelectorAll(".checkbox").forEach(check => {
    check.addEventListener("change", (e) => {
        if (e.target.checked) {
            i++;
            //closest méthode native de js qui va chercher l'élément parmi les ancêtres (pas les descendants) le plus proche de la cible.
            e.target.closest("tr").style.backgroundColor = "green";
        } else {
            i--;
            e.target.closest("tr").style.backgroundColor = "";
        }
        button.disabled = i != document.querySelectorAll(".checkbox").length;
    })
})

const updateOrderStatut = async () => {
    try {
        const response = await fetch(`/api.php?route=orders.php&number=${number}`, {
            method: "PATCH"
        });
        
        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }
        
        return true;
    } catch (error) {
        alert('Impossible de mettre à jour le statut de la commande. Veuillez réessayer.');
        return false;
    }
 }

button.addEventListener("click", async() => {
    const success = await updateOrderStatut();
    if (success) {
        window.location.href = '../html/index.html';
    }
 })