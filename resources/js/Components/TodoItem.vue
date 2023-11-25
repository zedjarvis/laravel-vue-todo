<script setup lang="ts">
import type { Todo } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { vOnClickOutside } from '@vueuse/components';
import { computed, ref, toRef } from 'vue';

const props = defineProps<{
  todo: Todo;
}>();

const todo = toRef(props, 'todo')
const edit = ref(false)
const input = ref<HTMLInputElement | null>(null)


const form = useForm({
  text: todo.value.text,
  done: todo.value.done
})

const isDone = computed(() => form.done)

const onSubmit = () => {
  form.put(route('todo.update', todo.value.id), { onSuccess: () => edit.value = false });
}

function updateDone() {
  form.done = !form.done
  onSubmit()
}

function deleteTodo() {
  form.delete(route('todo.destroy', todo.value.id))
}

const focusInput = () => {
  edit.value = true
  if (input.value) input.value.focus()
}

</script>


<template>
  <div
    class="group m-1 py-2 grid grid-cols-12 items-center border border-dotted border-gray-600 transition-all cursor-pointer"
    :class="{ 'text-green-500': form.done, 'line-through': form.done }">
    <div class="inline-flex justify-start col-span-1">
      <i @click="updateDone" class="ml-1" :class="{ 'i-carbon-checkbox-checked': isDone, 'i-carbon-checkbox': !isDone }"
        style="font-size: 25px;"></i>
    </div>
    <p v-if="edit" class="col-span-10">
    <form @submit.prevent="onSubmit">
      <input ref="input" v-on-click-outside="() => edit = false" @blur="edit = false" v-model="form.text" type="text"
        class="w-full border-none bg-slate-950" placeholder="Edit todo" autofocus="true">
      <p v-show="form.errors.text" class="text-sm text-red-600 dark:text-red-400">
        {{ form.errors.text }}
      </p>
      <p v-show="form.errors.done" class="text-sm text-red-600 dark:text-red-400">
        {{ form.errors.done }}
      </p>
      <!-- <button hidden aria-hidden="true" type="submit">Submit</button> -->
    </form>
    </p>
    <p v-else @click="focusInput" class="p-2 inline-flex items-center col-span-10">
      {{ form.text }}
    </p>
    <button @click="deleteTodo" class="hidden justify-end col-span-1 group-hover:inline-flex">
      <i class="i-carbon-trash-can text-red-500 mr-2" style="font-size: 20px;"></i>
    </button>
  </div>
</template>
