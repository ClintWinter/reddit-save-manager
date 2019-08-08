<template>
    <transition name="fade">
        <div
            v-if="errors.length > 0" 
            class="px-5 py-2 bg-red-800 fixed shadow-md inset-x-0 top-0 z-20">
            <p 
                class="text-lg font-bold color-white" 
                v-for="(error, index) in errors" 
                :key="index">{{ error.message }}</p>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['errors']
}
</script>
