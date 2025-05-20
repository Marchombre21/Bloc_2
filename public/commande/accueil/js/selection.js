import { Menu } from './classes.js'
const categoriesNav = document.getElementById("categories");
const categoriesContent = document.getElementById("content");
const headerProducts = document.querySelector("header");
// const modal = document.getElementById("choices");
const backgroundModal = document.getElementById("backgroundModal");
import './order.js';
import { orderContent, updateOrder, addToResult, substractFromResult } from './order.js';
// import './modal.js';
import { backgroundClick, openDrinksWindow, openMenusWindow } from './modal.js';
import { orderContentMenu } from "./order.js";

const getCategories = async () => {
    try{
        const categories = await fetch("/api.php?route=categories.php").then(res => res.json())
        return categories
    }catch (error) {
        console.error('Error fetching orders:', error);
        return [];
    }
}

const getProducts = async () => {
    try {
        const response = await fetch('/api.php?route=products.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const productsList = await response.json();
        return productsList;
    } catch (error) {
        console.error('Error fetching products:', error);
        return [];
    }
}

const categoriesList = await getCategories();
export const productsList = await getProducts();
// Création d'un tableau qui simplifie l'étape suivante.
// Edit: finalement je n'utilisais la class Categorie qu'une seule fois donc pas utile.
let categoriesArray = categoriesList.map(item => {
    const isSelected = item.name === "menus" ? "selected" : ""
    return (
        `
        <button class="categoriesButton ${isSelected}" data-id = ${item.id} >
            <figure>
                <img src="../../../img${item.image}" alt="${item.image}-logo" />
                <figcaption><div>${item.name}</div></figcaption>
            </figure>
        </button>
        `
        // new Categorie(item.title, item.image)
    )
})



// Ici ça permet d'ajouter la classe selected à la catégorie Menus au chargement de la page.
// let categorie = categoriesArray.map(item => {
//     const isSelected = item.title === "menus" ? "selected" : ""
//     return (
//         item.render(isSelected)
//     )
// }).join("")
// Le .join qui permet de transformer en chaine de caractères pour pouvoir y passer en argument à Menu.

categoriesNav.innerHTML = new Menu(categoriesArray.join(""), 1).render();
//On fait comme ça pour éviter de refaire une requête à chaque fois qu'on change de catégorie.
//Sinon on aurait fait une fonction async avec return await fetch(`../../../../api/products.php?category=${$category}`)
export const setCurrentCategorie = (category) => {
    return productsList.filter(product => product.category === Number(category));
}

// Le premier contenu à être affiché est celui des menus.
let currentCategorieContent = setCurrentCategorie(1);

export let chosenCategorie = "1";

backgroundModal.addEventListener("click", () => {
    backgroundModal.style.display = "none";
    if (chosenCategorie === "1") {
        backgroundClick();
    }

})

const setCurrentCategorieContent = () => {
    const categoryDatas = categoriesList.find(element => element.id == chosenCategorie);
    headerProducts.innerHTML = `
    <h1>Nos ${categoryDatas.name}</h1> 
    <p>${categoryDatas.description}</p>
    `
    let content = "";
    currentCategorieContent.forEach(product => {
        const disabled = product.available === 0 ? "disabled" : "";
        let message = "";
        if(product.available === 0){
            message = "INDISPONIBLE";
        }
        content += `
        <button class="productButton relative" ${disabled} data-image="${product.image}" data-name="${product.name}" data-price="${product.price}">
          <figure>
            <img src="../../../img/${product.image}" alt="${product.name}-logo">
            <figcaption>
                <strong>${product.name}</strong>
                <p>${product.price} €</p>
            </figcaption>
          </figure>
          <p class="absoluteCenter text-danger">${message}</p>
        </button>
    `
    })
    categoriesContent.insertAdjacentHTML('beforeend', content)

    // On définit les constantes après que le chargement a été fait.
    const categorieButtons = document.querySelectorAll(".categoriesButton");
    const productButtons = document.querySelectorAll(".productButton");
    const leftArrow = document.getElementById("leftArrow1");
    const rightArrow = document.getElementById("rightArrow1");
    const categories = document.getElementById("categoriesList1");


    // Ici on utilise la fonction native de js .scrollBy pour faire défiler un élément, et même plus précisemment, le scrollLeft qui gère le défilement horizontal (en opposition au scrollTop).


    rightArrow.addEventListener("click", () => {
        categories.scrollBy({ left: 200, behavior: 'smooth' })
    })

    leftArrow.addEventListener("click", () => {
        categories.scrollBy({ left: -200, behavior: 'smooth' })
    })

    categorieButtons.forEach(button => {
        button.addEventListener("click", () => {
            categorieButtons.forEach(item => {
                item.classList.remove("selected")
            })
            button.classList.add("selected")
            chosenCategorie = button.dataset.id;
            currentCategorieContent = setCurrentCategorie(chosenCategorie);
            categoriesContent.innerHTML = "";
            setCurrentCategorieContent();
        })
    });
    productButtons.forEach(button => {
        button.addEventListener("click", () => {
            const name = button.dataset.name;
            const price = button.dataset.price;
            const image = button.dataset.image;
            if (chosenCategorie === "1") {
                openMenusWindow()
                orderContentMenu.push({
                    name,
                    price,
                    supplements: []
                })
                const newName = name.replace("Menu ", "");
                orderContentMenu[orderContentMenu.length - 1].supplements.push(newName);
                backgroundModal.style.display = "flex"
                //Obligé de passer par une fonction pour ajouter au prix car l'import direct de result depuis un module fait passer la variable en constante (lecture seule d'après chatGPT) et on ne peut rien y réassigner.
                addToResult(price);
            } else if (chosenCategorie === "2") {
                openDrinksWindow(name, price, image);
                backgroundModal.style.display = "flex"
            } else {
                const index = orderContent.indexOf(orderContent.find(item => item.name === name));
                if (index != -1) {
                    orderContent[index].quantity += 1;
                    orderContent[index].price = Math.round(Number(orderContent[index].price) * 100 + Number(price) * 100) / 100
                } else {
                    orderContent.push({
                        name,
                        price,
                        quantity: 1
                    })
                }

                addToResult(price)
            }
            updateOrder()

        })
    });
}
setCurrentCategorieContent();
