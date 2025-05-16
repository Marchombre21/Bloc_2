const list = document.getElementById("list");

const getWaitingOrders = async () => {
    const waitingOrders = await fetch('../../../../api/orders')
}