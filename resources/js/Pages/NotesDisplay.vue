<script setup>
import { ref } from 'vue';


const props = defineProps(['note']);
const note = ref(props.note);

defineEmits(['delete'])

</script>
<template>
        
            <div class="flex">
                
                <h2 class="font-semibold mx-2" style="font-size: 2em;">{{ note.title }}</h2>

                <button 
                    class="delete-note ml-auto hover:text-red-500" 
                    title="Delete note"
                    @click="this.$emit('delete', note.id)"
                >
                    X
                </button>
            </div>
            <div class="my-2 mx-2">
                <p>{{ note.content }}</p>
            </div>
    
</template>

<style>
.delete-note{
    background-color: transparent;
    font-weight: 800;
    font-size: small;
    height: 1.5rem;
    width: 1.5rem;
    border: transparent;
}
.delete-note:hover{
    border-top: transparent;
    border-right: transparent;
    border-radius: 7px;
    box-shadow: 0px 1px 4px 3px rgba(0,0,0,0.49);
}
</style>
