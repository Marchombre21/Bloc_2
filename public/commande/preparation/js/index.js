const list = document.getElementById("list");

const getWaitingOrders = async () => {
    try {
        const response = await fetch('/api.php?route=orders.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const waitingOrders = await response.json();
        return waitingOrders;
    } catch (error) {
        console.error('Error fetching orders:', error);
        return [];
    }
 }


const orders = await getWaitingOrders();

let ordersList = orders.map(order => {
        return (
            `
          <a class="yellowButton col fw-bold" href="../html/details.html?number=${order.order_number}">Commande n° ${order.order_number} faite il y a ${order.time} minutes</a>
        `
        )
})

if(ordersList.length === 0){
    list.innerText = "Aucune commande à préparer."
}else{
    list.innerHTML = ordersList.join("");
}
