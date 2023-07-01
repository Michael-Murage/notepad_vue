<script setup>
import { ref } from 'vue';
import { toast } from 'vue3-toastify';


const emit = defineEmits(['update']);
const props = defineProps(['user_id']);

const newNote = ref({
    title: '',
    content: '',
    user_id: props.user_id
});

const resizeOption = ref(false);

async function saveNote(e) {
    e.preventDefault();
    if (!newNote.value.title) {
        toast('Title cannot be empty');
        return;
    }
    if (!newNote.value.content) {
        toast('Content cannot be empty');
        return;
    }
    
    try {
        const resp = await fetch('/api/notes', {
            headers: {
                'Content-Type': 'application/json',
                accept: 'application/json'
            },
            method: 'POST',
            body: JSON.stringify(newNote.value)
        });

        if (resp.ok) {
            const jsonResp = await resp.json();
            toast(jsonResp);
            emit('update', {
                    title: newNote.value.title,
                    content: newNote.value.content,
                }
            );
            newNote.value = {
                title: '',
                content: '',
                user_id: props.user_id
            };
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
}

function switchResize() {
    resizeOption.value = !resizeOption.value;
}
</script>

<template>
    <form 
        class="rounded-lg card py-2 bg-indigo-400 dark:bg-indigo-900"
        style="width: 18rem; 
        margin-top: 2px;"
        id="inputForm"
    >
        <div id="title-form">
            <input 
                type="text" 
                class="text-gray-900 bg-white dark:bg-gray-900 dark:text-white"
                id="title-input" 
                placeholder="Enter title"
                v-model="newNote.title"
            >
        </div>
        <div id="textarea-form">
            <textarea 
                class="text-gray-900 bg-white dark:bg-gray-900 dark:text-white"
                placeholder="Enter note content..." 
                id="textarea-input" 
                :style="{resize: (resizeOption ? 'both' : 'none')}"
                v-model="newNote.content"
            ></textarea>
        </div>
        <div id="submit-form">
            <input 
                type="submit" 
                class="text-gray-900 dark:text-white"
                id="submit-input" 
                value="Save"
                title="Save note"
                @click="saveNote($event)"
            >
            <input 
                type="button" 
                class="text-gray-900 dark:text-white submit-input"
                title="Resize is off" 
                value="Toggle resize"
                @click="switchResize"
            >
        </div>
    </form>
</template>