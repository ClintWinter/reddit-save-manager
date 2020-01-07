<template>
    <transition name="fade">
        <div
            v-if="message"
            class="px-5 py-2 fixed shadow-md inset-x-0 top-0 z-20 text-shadow"
            :class="classes"
        >
            <p class="text-lg font-bold">{{ message }}</p>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['status', 'message'],

    computed: {
        classes() {
            if ( this.status == 'neutral' ) {
                return 'bg-blue-600 text-blue-100';
            } else if ( this.status == 'warning' ) {
                return 'bg-yellow-600 text-yellow-100';
            } else if ( this.status == 'success' ) {
                return 'bg-green-600 text-green-100';
            }
        },
    }
}
</script>
