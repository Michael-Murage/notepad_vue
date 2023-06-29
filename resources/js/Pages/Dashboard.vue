<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';

const newNote = ref({
    title: '',
    content: ''
});

const data = ref([]);

async function fetchData() {
    try {
        const resp = await fetch('/api/notes');
        if (resp.ok) {
            const jsonResp = await resp.json();
            data.value = jsonResp;
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
}

onMounted(() => {
    fetchData();
});

function latestId() {
    if (data.value.length === 0) {
        return 1;
    } else {
        const lastElement = data.value[data.value.length - 1];
        const id = lastElement.id + 1;
        return id;
    }
}

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
            data.value.push(
                {
                    title: newNote.value.title,
                    content: newNote.value.content,
                    id: latestId()
                }
            );
            newNote.value = {
                title: '',
                content: ''
            };
        } else {
            const errorJson = await resp.json();
            toast.error(errorJson.message);
        }
    } catch (error) {
        toast.error(error.message);
    }
    
}

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
                                    style="resize: none;"
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
                                <!-- <input 
                                    type="button" 
                                    class="text-gray-900 dark:text-white submit-input"
                                    title="Resize is off" 
                                    value="Toggle resize"
                                > -->
                            </div>
                        </form>
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
                    <div class="flex">
                        
                        <h2 class="font-semibold" style="font-size: 2em;">{{ note.title }}</h2>

                        <button 
                            class="delete-note ml-auto hover:text-red-500" 
                            title="Delete note"
                            @click="deleteNote(note.id)"
                        >
                            X
                        </button>
                    </div>
                    <div class="my-2">
                        <p>{{ note.content }}</p>
                    </div>
                </div>
            </div>
            
        </div>
    </AuthenticatedLayout>
</template>

<style>
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-clip: border-box;
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
        background-color: transparent;
        box-shadow: 0 0 2em #646cffaa;
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
        box-shadow: 0 0 2em #545beeaa;
        color: #fee;
    }
    #submit-form{
        display: flex;
        justify-content: center;
    }

    .card{
        margin-top: 5px;
        margin-bottom: 5px;
        box-shadow: 0px 1px 4px 3px rgba(0,0,0,0.49);
        max-width: auto;
        min-width: min-content;
    }
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
