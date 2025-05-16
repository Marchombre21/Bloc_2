// export class Categorie {
//     constructor(title, image, price = "") {
//         this.title = title;
//         this.image = "../img/" + image;
//         this.price = price;

//     }
//     render(addClass = "") {
//         // Le data est là pour récupérer le nom de la catégorie plus tard.
//         return (
//             `
//             <button class="categoriesButton ${addClass}" data-title = ${this.title} >
//                 <figure>
//                     <img src=${this.image} alt="${this.image}-logo" />
//                     <figcaption><div>${this.title}${this.price}</div></figcaption>
//                 </figure>
//             </button>
//             `

//         );
//     }
// }

export class Menu {
    constructor(list, number) {
        this.list = list;
        //C'est ce que j'ai trouvé de mieux pour pallier au problème quand deux menus apparaissent sur la même page.
        this.number = number
    }
    render() {
        return (
            `
            <button type="button" id="leftArrow${this.number}" class="arrow ">
                <figure>
                    <img 
                    src="../../../img/images/fleche-slider.png" 
                    alt="leftArrow" />
                </figure>
            </button>

            <div id="categoriesList${this.number}">
            ${this.list}
            </div>

            <button type="button" id="rightArrow${this.number}" class="arrow ">
                <figure>
                    <img

                    src="../../../img/images/fleche-slider.png"
                    alt="rightArrow"/>
                </figure>
            </button>
        `
        )

    }
}

