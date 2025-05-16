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



// const presentationCategorie = {
//     menus: "Un sandwich, une friture ou une salade et une boisson.",
//     boissons: "Une petite soif, sucrée, légère et rafraîchissante!",
//     burgers: "Un délicieux problème de cholestérol enrobé de sauces très sucrées pour que les enfants en mangent.",
//     frites: "Croustillantes si elles n'avaient pas été tellement baignées dans l'huile qu'elles en gouttent encore.",
//     encas: "Pour ceux qui ont faim mais pas trop.",
//     wraps: "Laissez-vous wrapper!",
//     salades: "Aller au Wacdo pour une salade c'est comme aller dans une maison close pour un calin.",
//     desserts: "Encore un peu de sucre?",
//     sauces: "Au cas où il n'y en ait pas assez."
// };

const presentationCategorie = {
    "1": ["menus", "Un sandwich, une friture ou une salade et une boisson."],
    "2": ["boissons", "Une petite soif, sucrée, légère et rafraîchissante!"],
    "3": ["burgers", "Un délicieux problème de cholestérol enrobé de sauces très sucrées pour que les enfants en mangent."],
    "4": ["frites", "Croustillantes si elles n'avaient pas été tellement baignées dans l'huile qu'elles en gouttent encore."],
    "5": ["encas", "Pour ceux qui ont faim mais pas trop."],
    "6": ["wraps", "Laissez-vous wrapper!"],
    "7": ["salades", "Aller au Wacdo pour une salade c'est comme aller dans une maison close pour un calin."],
    "8": ["desserts", "Encore un peu de sucre?"],
    "9": ["sauces", "Au cas où il n'y en ait pas assez."],
};



// const contentModal = {
//     menus: {
//         1: {
//             title: "Une grosse faim?",
//             sentence: "Le menu maxi Best Of comprend un sandwich, une grande frite et une boisson 50 Cl (+ 2 €)",
//             images: {
//                 image1: "../img/images/illustration-maxi-best-of.png",
//                 image2: "../img/images/illustration-best-of.png"
//             },
//             imageTitle: {
//                 title1: "Menu Maxi Best Of",
//                 title2: "Menu Best Of"
//             },
//             button: "Étape suivante"
//         },
//         2: {
//             title: "Choisissez votre accompagnement",
//             sentence: "Frites, potatoes, la pomme de terre dans tous ses états",
//             images: {
//                 image1: "../img/frites/MOYENNE_FRITE.png",
//                 image2: "../img/frites/GRANDE_POTATOES.png"
//             },
//             imageTitle: {
//                 title1: "Frites",
//                 title2: "Potatoes"
//             },
//             button: "Étape suivante"
//         },
//         3: {
//             title: "Choisissez votre boisson",
//             sentence: "Un soda , un jus de fruit ou un verre d’eau pour accompagner votre repas",
//             button: "Ajouter le menu à ma commande"
//         }
//     },
//     boissons: {
//         title: "Une petite soif?",
//         sentence: "Choisissez la taille de votre boisson, +0.50€ pour le format 50 Cl",
//         imageTitle: {
//             title1: "30Cl",
//             title2: "50Cl"
//         },
//         button: {
//             button1: "Annuler",
//             button2: "Ajouter à ma commande"
//         }
//     }
// };

const getCategories = async () => {
    const categories = await fetch("../../../../api/categories.php").then(res => res.json())
    return categories
}

const getProducts = async () => {
    const productsList = await fetch('../../../../api/products.php').then(res => res.json());
    return productsList
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

// let step = 0;

// const openMenusWindow = (name, price) => {
//     step++;
//     let contentChoice = "";

//     if (step === 1 || step === 2) {
//         // &times; code natif d'html pour faire le signe de la multiplication.
//         contentChoice = `
//         <span id="closeButton" class="close">&times;</span>
//         <form action="" methode="get">
//         <header>
//             <h1>${contentModal[chosenCategorie][step].title}</h1>
//             <p>${contentModal[chosenCategorie][step].sentence}</p>
//         </header>
//             <div>
//                 <fieldset>
//                     <label for="maxi">
//                         <input type="radio" id="maxi" value="maxi" name="size">
//                         <figure><img src="${contentModal[chosenCategorie][step]["images"].image1}" alt=""></figure>
//                         <span>${contentModal[chosenCategorie][step]["imageTitle"].title1}</span>
//                     </label>
//                 </fieldset>
//                 <fieldset>
//                     <label for="best">
//                         <input type="radio" id="best" value="best" name="size">
//                         <figure><img src="${contentModal[chosenCategorie][step]["images"].image2}" alt=""></figure>
//                         <span>${contentModal[chosenCategorie][step]["imageTitle"].title2}</span>
//                     </label>
//                 </fieldset>
//             </div>

//             <button type="submit">${contentModal[chosenCategorie][step].button}</button>
//         </form>

//         `
//     }
//     modal.innerHTML = contentChoice;
//     backgroundModal.addEventListener("click", () => {
//         backgroundModal.style.display = "none";
//         step = 0
//     })
//     const closeButton = modal.querySelector("#closeButton").addEventListener("click", () => {
//         backgroundModal.style.display = "none";
//         step = 0
//     })
//     modal.addEventListener("click", (e) => {
//         // Astuce de chatGPT pour éviter que le clic ne remonte jusqu'à son parent qui, lui, ferme la modale quand on clique dessus.
//         e.stopPropagation();
//     })
//     const figures = modal.querySelectorAll("figure");
//     figures.forEach(figure => {
//         figure.addEventListener("click", () => {
//             figures.forEach(item => {
//                 item.classList.remove("selected")
//             })
//             figure.classList.add("selected")
//         })
//     });


// }

const setCurrentCategorieContent = () => {
    headerProducts.innerHTML = `
    <h1>Nos ${presentationCategorie[chosenCategorie][0]}</h1> 
    <p>${presentationCategorie[chosenCategorie][1]}</p>
    `
    let content = "";
    currentCategorieContent.forEach(product => {
        content += `
        <button class="productButton" data-image="${product.image}" data-name="${product.name}" data-price="${product.price}">
          <figure>
            <img src="../../../img/${product.image}" alt="${product.name}-logo">
            <figcaption>
                <strong>${product.name}</strong>
                <p>${product.price} €</p>
            </figcaption>
          </figure>
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
