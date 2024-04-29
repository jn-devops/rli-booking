<!-- 
<script setup>
import { ref } from 'vue';

const items = ref([
  {
    title: 'Item 1',
    description: 'Description for item 1',
    image: 'http://127.0.0.1:5173/resources/img/ProductImg.png',
  },
  {
    title: 'Item 2',
    description: 'Description for item 2',
    image: 'http://127.0.0.1:5173/resources/img/Agapeya_img.png',
  }
]);

const activeIndex = ref(0);

const nextItem = () => {
  activeIndex.value = (activeIndex.value + 1) % items.value.length;
};

const prevItem = () => {
  activeIndex.value = (activeIndex.value - 1 + items.value.length) % items.value.length;
};
</script>
<template>
    <div class="carousel-container">
    <div class="carousel">
      <button @click="prevItem" class="prev-btn">Prev</button>
      <div class="carousel-inner">
        <div 
          v-for="(item, index) in items" 
          :key="index" 
          :class="{ 'active': index === activeIndex }" 
          class="carousel-item"
        >
          <img :src="item.image" alt="carousel item" class="carousel-image" />
          <div class="carousel-caption">
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
          </div>
        </div>
      </div>
      <button @click="nextItem" class="next-btn">Next</button>
    </div>
  </div>
</template>

<style>

.carousel-container {
  display: flex;
  justify-content: center;
}

.carousel {
  position: relative;
}

.carousel-inner {
  display: flex;
  overflow: hidden;
}

.carousel-item {
  display: none;
}

.carousel-item.active {
  display: block;
}

.carousel-image {
  width: 100%;
  height: auto;
}

.carousel-caption {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 10px;
}

.prev-btn, .next-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
}

.prev-btn {
  left: 10px;
}

.next-btn {
  right: 10px;
}
</style> -->
<script setup>
import { Carousel, Navigation, Slide } from 'vue3-carousel';
import { defineComponent, ref, computed  } from 'vue';
import 'vue3-carousel/dist/carousel.css';

const props = defineProps({
    products: Object,
    property: String
});

// const items = ref([
//     {
//       title: 'Agapeya Duplex House and Lot 1',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Rectangle_39.png',
//     },
//     {
//       title: 'Agapeya Duplex House and Lot 2',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Agapeya_img.png',
//     },
//     {
//       title: 'Agapeya Duplex House and Lot 3',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Rectangle_39.png',
//     },
//     {
//       title: 'Agapeya Duplex House and Lot 4',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Agapeya_img.png',
//     },
//     {
//       title: 'Agapeya Duplex House and Lot 5',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/ProductImg.png',
//     },
//     {
//       title: 'Zaya Studio Condominium 1',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Rectangle_39.png',
//     },
//     {
//       title: 'Zaya Studio Condominium 2',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Agapeya_img.png',
//     },
//     {
//       title: 'Zaya Studio Condominium 3',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/ProductImg.png',
//     },
//     {
//       title: 'Zaya Studio Condominium 4',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Rectangle_39.png',
//     },
//     {
//       title: 'Zaya Studio Condominium 5',
//       price: '₱2,900,000',
//       description: 'Total Contract Price',
//       image: 'http://127.0.0.1:5173/resources/img/Agapeya_img.png',
//     },
//   ]
// )

const items = ref({});
items.value = props.products;
// console.log('Items:', items);
// console.log('property: ', props.property);


// console.log("property", props.property);
defineComponent({
  name: 'WrapAround',
  components: {
    Carousel,
    Slide,
    Navigation,
  }
});

const searchBrand = ref('');

const filteredItems = computed(() => {
  if (!items.value) return [];

  return items.value.filter(item => {
    return item.brand.includes(props.property) && !item.type.includes('configurable');
  });
});

 // Computed property to filter items based on property
//  const filteredItems = computed(() => {
//   return items.value 
//     ? items.value.filter(item => item.brand.includes(items.value))
//     : items.value;
// });

const emit = defineEmits(['view-details']);

const vDetails = ref(null);
const viewDetails = (parameter) =>{
  // console.log('params: ', parameter);
  vDetails.value = parameter;
  emit('view-details', parameter);
}

</script>
<template>
  <!-- <p>1</p> -->
  <Carousel :items-to-show="3" :wrap-around="true">
    <Slide 
    v-for="(listItem, index) in filteredItems" :key="index"
    >
      <div
      class="carousel__item mx-1 h-96 rounded-lg dark:text-white light:text-black">
        <img :src="listItem.url_links.facade" alt="item image" class="carousel__image h-56">
        <div class="carousel__content">
          <h3 class="carousel__title font-bold text-sm">{{ listItem.name }}</h3>
          <p class="font-bold text-sm mb-0">₱{{ listItem.price.toLocaleString() }}</p>
          <p class="carousel__description text-sm">{{ listItem.brand }}</p>
          <div class="w-full mt-1">
           <button 
           @click="viewDetails(listItem)"
           class="border border-rose-500 bg-white text-rose-500 px-3 py-1 w-full rounded-full hover:bg-rose-500 hover:text-white">View Details</button>
          </div>
        </div>
      </div>
    </Slide>

    <template #addons>
      <Navigation />
    </template> 
  </Carousel>
</template>



<style>
.carousel__item {
  position: relative; /* Set position to relative for absolute positioning of title and description */
  display: flex;
  justify-content: center;
  align-items: start;
  /* overflow: hidden; */
}

.carousel__image {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
  z-index: 1;
}

.carousel__content {
  position: absolute; /* Position the content absolutely */
  bottom: 5px; /* Align the content to the bottom */
  left: 0;
  right: 0;
  /* background-color: rgba(0, 0, 0, 0.7);  Add a semi-transparent background to make text readable */
  padding: 10px; /* Add padding to the content */
  text-align: left; /* Center-align the text */
  z-index: 5;
  
}

.carousel__title {
  margin-bottom: 5px; /* Add some space between title and description */
  /* color: #000; Set text color */
}

.carousel__description {
  margin: 0;
  /* color: #000; Set text color */
}

.carousel__next, .carousel__prev{
  background-color: #f8f8f8;
}

</style>
