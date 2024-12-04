// const componentList = document.querySelector(".component-list");
// const sortSelect = document.getElementById("sort");

// // Sample component data
// const components = [
//   {
//     name: "ThermalTake AIR killer",
//     price: 29.99,
//     category: "CPU Coolers",
//     img: "TheramlTake Air Cooler",
//   },
//   {
//     name: "ASRock A520M-HVS",
//     price: 68.99,
//     category: "Motherboards",
//     img: "ASRock_4710483932311",
//   },
//   {
//     name: "16GB RAM KINGSTON FURY  DDR5",
//     price: 129.99,
//     category: "RAM",
//     img: "Kingston_740617331875",
//   },
//   {
//     name: "Gigabyte Windforce GeForce RTX 4090 24GB GDDR6X",
//     price: 1799.99,
//     category: "Graphic Cards - VGA",
//     img: "Gigabyte_889523033975",
//   },
//   {
//     name: "M.2 1TB NVMe SSD",
//     price: 57.99,
//     category: "SSDs and NVMe Drives",
//     img: "Addlink_4712927862406",
//   },
//   {
//     name: "1TB HDD Seagate",
//     price: 19.99,
//     category: "HDDs",
//     img: "Seagate_141412",
//   },
//   {
//     name: "Raidmax X08 Metal Mid Tower Open Air Case",
//     price: 149.99,
//     category: "Computer Case",
//     img: "Raidmax_719392166231",
//   },
//   {
//     name: "Cooler Master Elite V4 600W 80Plus",
//     price: 46.99,
//     category: "Power Supply Units - PSU",
//     img: "Cooler Master_884102056529",
//   },
//   {
//     name: "Grizzly Thermal Paste 1Gram",
//     price: 9.99,
//     category: "Thermal Paste and Pads",
//     img: "Thermal Grizzly_753677507630",
//   },
//   {
//     name: "Case Fan",
//     price: 3.99,
//     category: "Case Accessories",
//     img: "rgbFan",
//   },
// ];

// // Helper function to create component card HTML
// function createComponentCard(component) {
//   const card = document.createElement("div");
//   card.classList.add("component-card");
//   card.innerHTML = `
//         <img src="AvailableParts/${component.img}.jpg" alt="${component.name}">
//         <h3>${component.name}</h3>
//         <p>${component.category}</p>
//         <p class="price">$${component.price.toFixed(2)}</p>
//         <button class="btn"> Add to cart </button>
//     `;
//   return card;
// }

// // Function to render component cards
// function renderComponents(sortOption) {
//   componentList.innerHTML = "";

//   let sortedComponents;
//   switch (sortOption) {
//     case "name-asc":
//       sortedComponents = [...components].sort((a, b) =>
//         a.name.localeCompare(b.name)
//       );
//       break;
//     case "price-asc":
//       sortedComponents = [...components].sort((a, b) => a.price - b.price);
//       break;
//     case "price-desc":
//       sortedComponents = [...components].sort((a, b) => b.price - a.price);
//       break;
//     default:
//       sortedComponents = [...components];
//   }

//   sortedComponents.forEach((component) => {
//     const card = createComponentCard(component);
//     componentList.appendChild(card);
//   });
// }

// renderComponents();

// // Event listener for sort select
// sortSelect.addEventListener("change", (event) => {
//   const sortOption = event.target.value;
//   renderComponents(sortOption);
// });
