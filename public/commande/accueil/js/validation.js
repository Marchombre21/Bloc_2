const list = document.getElementById("list");
const sentence = document.getElementById("sentence");
const button = document.querySelector('#checked');

const getWaitingOrders = async () => {
    const waitingOrders = await fetch('../../../../api/orders.php?action=valid').then(res => res.json());
    return waitingOrders;
}


const orders = await getWaitingOrders();

const validOrders = orders.map((item, index) => {
    return (
        `
        <tr>
              <td><input type="radio" class="radio" name="order" value="${item.order_number}" id="order${index}"></td>
              <td><label for="order${index}">${item.order_number}</label></td>
              <td>${item.tableTent}</td>
              <td>${item.order_price} €</td>
        </tr>
        `
    )
});
list.innerHTML = validOrders.join("");
const radios = document.querySelectorAll(".radio");
radios.forEach(check => {
    check.addEventListener("change", (e) => {
        radios.forEach(radio => {
            if (radio.checked) {
                radio.closest("tr").style.backgroundColor = "green";
            } else {
                radio.closest("tr").style.backgroundColor = "";
            }
        })

        button.disabled = false;
    })
})

let message = "";

const deleteOrder = async (number) => {
    const answer = await fetch(`../../../../api/orders.php?number=${number}`, {
        method: "DELETE"
    }).then(res => res.json());
    if(answer.success){
        return true;
    }else{
        return false;
        message = answer;
    }
}

button.addEventListener("click", async (e) => {
    // e.preventDefault();
    // const params = new URLSearchParams(window.location.search);
    const orderNumber = document.querySelector("input[name='order']:checked").value;
    if (orderNumber) {

        if (await deleteOrder(orderNumber)) {
            window.location.href = "../index.html"
        } else {
            sentence.innerText = `Une erreur est survenue lors de la validation de la commande : ${message}`
        }
    } else {
        sentence.innerText = "Aucune commande sélectionnée."
    }
})