<template>
    <div class="h-screen flex items-center justify-center">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-3xl text-red-500 mb-6">Whoopss!...404</h1>
            <p class="text-lg text-blue-500 mb-6" v-text="$t('messages.page_not_found')"></p>

            <button @click="$router.push({name: 'app.home'})"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <span class="mr-2">{{ $t('messages.home') }}</span>
                <font-awesome-icon :icon="['fas', 'home']" size="lg"/>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
    }
</script>
