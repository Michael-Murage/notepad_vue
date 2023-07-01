<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import NotesDisplay from './NotesDisplay.vue';
import NewNote from './NewNote.vue';


const props = defineProps({
    user_id: { 
        type: Number
    }
});

const data = ref([]);

async function fetchData() {
    try {
        const resp = await fetch('/api/notes');
        if (resp.ok) {
            const jsonResp = await resp.json();
            data.value = jsonResp.filter(note => note.user_id === props.user_id);
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
}

onMounted(fetchData);

async function deleteNote(id) {
    try {
        const resp = await fetch(`/api/notes/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                accept: 'application/json'
            }
        });
    
        if (resp.ok) {
            const jsonResp = await resp.json();
            toast(jsonResp);
            data.value = data.value.filter(item => item.id !== id);
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
}

function updateDisplayedNotes(newNote) {
    data.value.push({
        title: newNote.title,
        content: newNote.content,
        id: latestId()
    });
}

function latestId() {
    if (data.value.length === 0) {
        return 1;
    } else {
        const lastElement = data.value[data.value.length - 1];
        const id = lastElement.id + 1;
        return id;
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <NewNote v-on:update="(newNote) => updateDisplayedNotes(newNote)" :user_id="props.user_id"/>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-around mx-8 mt-8">
                <div 
                    v-for="note in (Array.isArray(data) ? data : [])" 
                    :key="note.id"
                    class="card rounded-md mx-3 my-3"
                    style="width: auto; background-color: rgb(133, 189, 125);"
                >
                    <NotesDisplay :note="note" v-on:delete="(id) => deleteNote(id)"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    * {
        box-sizing: border-box;
        margin-left: 1.5px;
        margin-right: 1.5px;
    }
    #title-input, #textarea-input, .title-input, .textarea-input{
        width: 60%;
        border-radius: 0.5rem;
        border: transparent;
    }
    #textarea-input, .textarea-input{
        align-items: center;
        width: 90%;
    }
    .title-input{
        margin-left: 1em;
    }
    #textarea-input:hover, #title-input:hover, .textarea-input:hover, .title-input:hover{
        box-shadow: 0 0 2em var(--light-blue);
    }
    #title-form, .about-form{
        display: flex;
        justify-content: flex-start;
        margin-top: 2px;
        padding-left: 1em;
    }
    #textarea-form, .textarea-form{
        display: flex;
        margin-bottom: 2px;
        justify-content: center;
        margin-top: 2px;
    }
    #submit-input, .submit-input{
        width: 40%;
        background-color: transparent;
        margin-bottom: 2px;
        border: transparent;
    }
    #submit-input:hover, .submit-input:hover{
        box-shadow: 0 0 1em var(--light-blue);
        color: #fee;
    }
    #submit-form{
        display: flex;
        justify-content: center;
    }
    .flex-wrap{
        flex-wrap: wrap;
    }
</style>
