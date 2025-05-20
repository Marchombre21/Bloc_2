const list = document.getElementById("list");
const sentence = document.getElementById("sentence");
const button = document.querySelector('#checked');

const getWaitingOrders = async () => {
    try {
        const response = await fetch('/api.php?route=orders.php&action=valid');
        if (!response.ok) {
            throw new Error(`API returned status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching orders:', error);
        return [];
    }
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

if (validOrders.length === 0) {
    sentence.innerText = "Aucune commande en attente de validation.";
    list.innerHTML = "";
} else {
    sentence.innerText = "";
    list.innerHTML = validOrders.join("");
}

const radios = document.querySelectorAll(".radio");
radios.forEach(check => {
    check.addEventListener("change", () => {
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
    try {
        const response = await fetch(`/api.php?route=orders.php&number=${number}`, {
            method: "DELETE"
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const answer = await response.json();
        
        if (answer.success) {
            return true;
        } else {
            console.error(answer.error);
            return false;
        }
    } catch (error) {
        console.error('Error deleting order:', error);
        return false;
    }
}

button.addEventListener("click", async (e) => {
    const selectedOrder = document.querySelector("input[name='order']:checked");
    const orderNumber = selectedOrder ? selectedOrder.value : null;
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