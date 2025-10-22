
1- Install Vue.js4
2- Install Router + Botstrap + Boostrap icons +  AXios
3- Adding Navbar and implemnt to App.js
4- Install pinia
5- Create the  path src/store/useProductStore.js
6- Create the  path components/products/ProductList + ProudctListItem
7- display all producs inside productListItem
8- install npm i vue-loading-overlay
9- Install npm i vue-dompurify-html
10- Install vue-dompurify-html is a Vue.js plugin that safely renders HTML by sanitizing it with DOMPurify.
It helps prevent XSS (Cross-Site Scripting) attacks by removing any malicious or unsafe code before displaying user-generated or external HTML content.

Key benefits:

🛡️ Protects your app from XSS attacks

🧹 Cleans and sanitizes HTML automatically

⚙️ Easy to use with v-dompurify-html directive

🔧 Fully customizable allowed tags and attribut

11- install pacgke https://www.npmjs.com/package/vue-image-zoome
12- Display the product detials
13- Create the store add cart 
14- for Notidafaction i use the libary [Vue Toastification](https://github.com/Maronato/vue-toastification)



15- install [Pinia Plugin Persistedstate](https://www.npmjs.com/package/pinia-plugin-persistedstate)The pinia-plugin-persistedstate allows automatic state persistence in Pinia stores using localStorage or sessionStorage, enhancing user experience by retaining state across sessions.

16- Install strip cd bacend then composer require stripe/stripe-php








+++++++++++++++++++++++++++++++++++++++++++++++
What is Pinia?

Pinia is a state management library for Vue.js.
It lets you store and manage shared data (state) in one central place.

🔹 Why use it?

In small apps, you can pass data between components using props and emits.
But in large apps, this becomes messy and hard to maintain.
Pinia helps by giving you one global store where all components can:

Read data

Update data

React to changes easily

🔹 Simple example

Without Pinia:
You have a Navbar (shows cart count 🛒) and ProductList (adds items).
You’d have to pass data through many components.

With Pinia:
You create a cart store, save cartItems there.
When ProductList adds an item → Pinia updates the store → Navbar automatically sees the new count. ✅

🔹 Advantages

Official Vue state manager (replaces Vuex)

Very simple and modern syntax

Works great with Vue 3 Composition API

Fast, lightweight, and supports TypeScript

🔹 In short

🧠 Pinia = Central place to manage and share state in a Vue app
It keeps your code cleaner, easier to maintain, and more organized.