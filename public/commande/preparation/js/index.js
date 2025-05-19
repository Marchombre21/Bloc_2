const list = document.getElementById("list");

const getWaitingOrders = async () => {
    const waitingOrders = await fetch('../../../../api/orders.php').then(res => res.json());
    return waitingOrders;
}


const orders = await getWaitingOrders();


// Même quand la commande est complétée, map va retourner un undefined. Donc je ne peux pas jouer sur la taille du tableau pour savoir s'il y a des commandes à valider.
let ordersList = orders.map(order => {
    if (order.isCompleted === 0) {
        return (
            `
          <a class="yellowButton col fw-bold" href="../html/details.html?number=${order.order_number}">Commande n° ${order.order_number} faite il y a ${order.time} minutes</a>
        `
        )
    }

}).filter(element => element != undefined);

if(ordersList.length === 0){
    list.innerText = "Aucune commande à préparer."
}else{
    list.innerHTML = ordersList.join("");
}



// const orders2 = document.querySelectorAll("button[type='button']");
// orders2.forEach(item => {
//     item.addEventListener("click", (e) => {
//         header
//     })
// })
