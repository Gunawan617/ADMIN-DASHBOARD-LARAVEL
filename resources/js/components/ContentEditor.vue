
<template>
  <div>
<div class="editor-toolbar">
  <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ active: editor.isActive('bold') }"><b>B</b></button>
  <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ active: editor.isActive('italic') }"><i>I</i></button>
  <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="{ active: editor.isActive('underline') }"><u>U</u></button>
  <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="{ active: editor.isActive('strike') }"><s>S</s></button>
  <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ active: editor.isActive('heading', { level: 1 }) }">H1</button>
  <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ active: editor.isActive('heading', { level: 2 }) }">H2</button>
  <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ active: editor.isActive('bulletList') }">• List</button>
  <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ active: editor.isActive('orderedList') }">1. List</button>
  <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ active: editor.isActive('blockquote') }">❝</button>
  <button type="button" @click="editor.chain().focus().toggleCode().run()" :class="{ active: editor.isActive('code') }">&lt;/&gt;</button>
  <button type="button" @click="addLink">🔗</button>
  <button type="button" @click="addImage">🖼️</button>
  <button type="button" @click="editor.chain().focus().undo().run()">Undo</button>
  <button type="button" @click="editor.chain().focus().redo().run()">Redo</button>
  <button type="button" @click="editor.chain().focus().setHorizontalRule().run()">───</button>

</div>

    <editor-content :editor="editor" class="editor" />
    <input v-if="syncToTextarea" type="hidden" :name="syncToTextarea" :value="editor?.getHTML()" />
  </div>
</template>


<script setup>
import { ref, watch, onBeforeUnmount } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import Blockquote from '@tiptap/extension-blockquote'
import Code from '@tiptap/extension-code'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import HorizontalRule from '@tiptap/extension-horizontal-rule'


const props = defineProps({
  content: {
    type: String,
    default: '',
  },
  syncToTextarea: {
    type: String,
    default: '', // jika ingin sinkron ke textarea hidden, isi dengan nama field
  },
})
const emit = defineEmits(['update:content'])

const editor = ref()

editor.value = new Editor({
  extensions: [
    StarterKit,
    Underline,
    Strike,
    Blockquote,
    Code,
    Link,
    Image,
    HorizontalRule, // ✅ tambahkan di sini
  ],
  content: props.content || '<p>Tulis konten di sini...</p>',
  onUpdate({ editor }) {
    emit('update:content', editor.getHTML())
  },
})

function addLink() {
  const url = window.prompt('Masukkan URL')
  if (url) {
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
  }
}

function addImage() {
  const url = window.prompt('Masukkan URL gambar')
  if (url) {
    editor.value.chain().focus().setImage({ src: url }).run()
  }
}

// Sync prop changes from parent
watch(
  () => props.content,
  (newContent) => {
    if (editor.value && newContent !== editor.value.getHTML()) {
      editor.value.commands.setContent(newContent || '<p>Tulis konten di sini...</p>')
    }
  }
)

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>

<style scoped>
.editor-toolbar {
  margin-bottom: 8px;
}
.editor-toolbar button {
  margin-right: 4px;
  padding: 4px 8px;
  border: 1px solid #ccc;
  background: #f9f9f9;
  cursor: pointer;
  border-radius: 3px;
}
.editor-toolbar button.active {
  background: #e0e7ff;
  border-color: #6366f1;
}
.editor {
  border: 1px solid #ddd;
  border-radius: 4px;
  min-height: 200px;
  padding: 10px;
  background: #fff;

}



</style>
