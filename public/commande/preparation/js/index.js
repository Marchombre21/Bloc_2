const list = document.getElementById("list");

const getWaitingOrders = async () => {
    const waitingOrders = await fetch('../../../api/orders.php').then(res => res.json());
    return waitingOrders;
}


const orders = await getWaitingOrders();

const getDetailsOrder = async (number) => {
    const detailsOrders = await fetch(`../../../api/orders.php?number=${number}`).then(res => res.json());
    console.table(detailsOrders);
    return detailsOrders;
}

const ordersList = orders.map(order => {
    return (
        `
          <button type="button" data-number="${order.order_number}">Commande n° ${order.order_number} faite il y a ${order.time} minutes</button>
        `
    )
})

list.innerHTML = ordersList.join("");

const orders2 = document.querySelectorAll("button[type='button']");
orders2.forEach(item => {
    item.addEventListener("click", (e) => {
        getDetailsOrder(e.target.dataset.number);
    })
})
