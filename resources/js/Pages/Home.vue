<script setup lang="ts">
import TodoItem from '@/Components/TodoItem.vue';
import { Todo } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion: string;
  phpVersion: string;
  todos: Todo[];
}>();

const done = ref(false)
const edit = ref(false)
const text = ref("Finish my React Laravel Blog")

const form = useForm({
  text: ''
})
</script>

<template>
  <Head title="Home" />
  <div class="min-h-screen w-full bg-black text-slate-200 relative flex justify-center py-10">
    <div class="w-[400px] h-fit relative border border-gray-600">
      <div class="sticky top-0 flex items-center justify-between h-10 bg-gray-500 border border-gray-600 px-3">
        <h1 class="font-bold inline-flex items-center"><i class="i-carbon-task mx-2" style="font-size: 25px;"></i> DONE.io
        </h1>
        <i class="i-carbon-help" style="font-size: 20px;"></i>
      </div>
      <div class="h-[500px] w-full overflow-y-auto">
        <template v-for="todo in todos" :key="todo.id">
          <TodoItem :todo="todo" />
        </template>
      </div>
      <form @submit.prevent="form.post(route('todo.store'), { onSuccess: () => form.reset() })"
        class="absolute w-full bottom-0 left-0 px-3 py-2 bg-black border-t border-gray-600">
        <div class="flex items-center w-full">
          <input type="text" name="todo" id="id" v-model="form.text" class="w-full bg-black border"
            placeholder="Enter New todo...">
          <button type="submit" class="inline-flex items-center border border-gray-600 mx-1 px-2 h-[42px]"><i
              class="i-carbon-add"></i>
            Add</button>
        </div>
        <div v-show="form.errors.text">
          <p class="text-sm text-red-600 dark:text-red-400">
            {{ form.errors.text }}
          </p>
        </div>
      </form>
    </div>
  </div>
</template>
