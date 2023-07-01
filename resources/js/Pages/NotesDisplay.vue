<script setup>
import { ref } from 'vue';
import { toast } from 'vue3-toastify';


const props = defineProps(['note']);
const note = ref(props.note);
const editNote = ref(false);
const editedNote = ref(note);
const resize = ref(false);
const resizeValue = ref(false);

defineEmits(['delete'])

function editNoteTrue() {
    if (!editNote.value) editNote.value = true;
}

async function editNoteFalse() {
    try {
        const resp = await fetch(`/api/notes/${editedNote.value.id}`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json', accept: 'application/json'},
            body: JSON.stringify(editedNote.value)
        });
        if (resp.ok) {
            const jsonResp = await resp.json();
            toast(jsonResp);
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
    
    editNote.value = false;
}

function switchResize() {
    resize.value = !resize.value;
}

function resizeValueTrue() {
    if (!resizeValue.value) resizeValue.value = true;
}

function resizeValueFalse() {
    if (resizeValue.value) resizeValue.value = false;
}
</script>
<template>
        
    <div class="flex">
        
        <h2 
            :class="'font-semibold mx-2 ' + (editNote ? 'hidden' : '')" 
            style="font-size: 2em;"
            @click="editNoteTrue"
        >
            {{ note.title }}
        </h2>
        <form
            :class="'' + (editNote ? '' : 'hidden')"
            :id="'editNoteTitle' + note.id"
        >
            <input 
                :name="'editNoteTitleInput' + note.id" 
                type="text" 
                class="ml-3 text-gray-900 bg-white dark:bg-gray-900 dark:text-white border-transparent rounded-md"
                v-model="editedNote.title"
            >
        </form>

        <button 
            class="delete-note ml-auto hover:text-red-500" 
            title="Delete note"
            @click="this.$emit('delete', note.id)"
        >
            X
        </button>
    </div>
    <div :class="'my-2 mx-2 ' + (editNote ? 'hidden' : '')" @click="editNoteTrue">
        <p>{{ note.content }}</p>
    </div>

    <form :class="editNote ? '': 'hidden'">
        <div class='textarea-form'>
            <textarea 
                :id="'textareaEditNote' + editedNote.id"
                class="textarea-input text-gray-900 bg-white dark:bg-gray-900 dark:text-white border-transparent rounded-md"
                v-model="editedNote.content" 
                :style="{resize: (resize ? 'both' : 'none')}"
            >
            </textarea>
        </div>
        <div class='submit-form'>
            <input 
                type='button' 
                :id="editedNote.id" 
                value='Save' 
                class='submit-input' 
                @click="editNoteFalse"
            />
            <input 
                type="button"
                :title="resize ? 'Resize is on' : 'Resize is off'"
                :value="resizeValue ? (resize ? 'On' : 'Off') : 'Toggle resize'"
                class='submit-input' 
                @click="switchResize"
                @mouseover="resizeValueTrue"
                @mouseleave="resizeValueFalse"
            />
        </div>
    </form>
    
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
