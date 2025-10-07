<template>
  <div class="filament-style-editor">
    <div class="editor-toolbar">
      <!-- Format Tools -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ active: editor.isActive('bold') }" title="Bold">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M6 4v2h2V4h6v2h-2v8h2v2H8v-2h2V8H8V6H6V4zm4 0h2v12H8V4h2z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ active: editor.isActive('italic') }" title="Italic">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 4v2h1.586l-3 8H7v2h6v-2h-1.586l3-8H16V4h-6z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="{ active: editor.isActive('underline') }" title="Underline">
          <span class="font-bold underline">U</span>
        </button>
        <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="{ active: editor.isActive('strike') }" title="Strikethrough">
          <span class="line-through">S</span>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Headings -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ active: editor.isActive('heading', { level: 1 }) }" title="Heading 1">
          <span class="text-lg font-bold">H1</span>
        </button>
        <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ active: editor.isActive('heading', { level: 2 }) }" title="Heading 2">
          <span class="text-base font-bold">H2</span>
        </button>
        <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ active: editor.isActive('heading', { level: 3 }) }" title="Heading 3">
          <span class="text-sm font-bold">H3</span>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Lists -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ active: editor.isActive('bulletList') }" title="Bullet List">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 6a2 2 0 110-4 2 2 0 010 4zM4 14a2 2 0 110-4 2 2 0 010 4zM4 22a2 2 0 110-4 2 2 0 010 4zM8 5h8v2H8V5zm0 8h8v2H8v-2zm0 8h8v2H8v-2z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ active: editor.isActive('orderedList') }" title="Numbered List">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4h1v3H3V4zm0 5h1v1H3V9zm0 3h1v3H3v-3zm3-7h11v2H6V4zm0 4h11v2H6V8zm0 4h11v2H6v-2z"/></svg>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Special Elements -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ active: editor.isActive('blockquote') }" title="Quote">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10c0-1.657 1.343-3 3-3s3 1.343 3 3c0 .657-.171 1.274-.469 1.808L6.5 15H4l2.031-3.192A3 3 0 013 10zm8 0c0-1.657 1.343-3 3-3s3 1.343 3 3c0 .657-.171 1.274-.469 1.808L14.5 15H12l2.031-3.192A3 3 0 0111 10z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().toggleCode().run()" :class="{ active: editor.isActive('code') }" title="Inline Code">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.962 8.795l1.414-1.414L12 4l-3.376 3.381 1.414 1.414L12 6.828l1.962 1.967zM6.038 11.205L4.624 12.62 8 16l3.376-3.38-1.414-1.415L8 13.172l-1.962-1.967z"/></svg>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Spacing Controls -->
      <div class="toolbar-group">
        <button type="button" @click="addLineBreak" title="Line Break (Soft Return)">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1z"/></svg>
        </button>
        <button type="button" @click="addEmptyParagraph" title="Add Empty Paragraph">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Media & Links -->
      <div class="toolbar-group">
        <button type="button" @click="addLink" title="Add Link" class="link-button">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"/></svg>
        </button>
        <button type="button" @click="addImage" title="Add Image">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg>
        </button>
      </div>

      <!-- Divider -->
      <div class="toolbar-divider"></div>

      <!-- Actions -->
      <div class="toolbar-group">
        <button type="button" @click="editor.chain().focus().undo().run()" title="Undo">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a7 7 0 717-7h6.586l-2.293-2.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L16.586 5H10a5 5 0 00-5 5v5a1 1 0 01-2 0v-5z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().redo().run()" title="Redo">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17 10a7 7 0 01-7 7H3.414l2.293 2.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L3.414 15H10a5 5 0 005-5V5a1 1 0 112 0v5z"/></svg>
        </button>
        <button type="button" @click="editor.chain().focus().setHorizontalRule().run()" title="Horizontal Rule">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10h14a1 1 0 100-2H3a1 1 0 100 2z"/></svg>
        </button>
      </div>
    </div>

    <editor-content :editor="editor" class="filament-editor-content" />
    <input v-if="syncToTextarea" type="hidden" :name="syncToTextarea" :value="editor?.getHTML()" />
    
    <!-- Tips & Character Count -->
    <div class="editor-footer">
      <div class="text-xs text-gray-400">
        Press <kbd class="kbd">Shift+Enter</kbd> for line breaks, <kbd class="kbd">Enter</kbd> for new paragraphs
      </div>
      <span class="text-sm text-gray-500">
        {{ contentLength }} characters
      </span>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onBeforeUnmount, computed } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Strike from '@tiptap/extension-strike'
import Blockquote from '@tiptap/extension-blockquote'
import Code from '@tiptap/extension-code'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'

const props = defineProps({
  content: {
    type: String,
    default: '',
  },
  syncToTextarea: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: 'Start writing...',
  },
})

const emit = defineEmits(['update:content'])

const editor = ref()
const currentContent = ref('')

// Simple character count
const contentLength = computed(() => {
  return currentContent.value.replace(/<[^>]*>/g, '').length
})

editor.value = new Editor({
  extensions: [
    StarterKit.configure({
      // Configure paragraph to preserve empty paragraphs
      paragraph: {
        HTMLAttributes: {
          class: 'editor-paragraph',
        },
      },
      // Configure hard break for line breaks
      hardBreak: {
        keepMarks: false,
        HTMLAttributes: {
          class: 'editor-break',
        },
      },
    }),
    Underline,
    Strike,
    Blockquote,
    Code,
    Link.configure({
      openOnClick: false,
      HTMLAttributes: {
        target: '_blank',
        rel: 'noopener noreferrer',
      },
    }),
    Image,
  ],
  content: props.content || `<p>${props.placeholder}</p>`,
  // Enable preserveWhitespace to keep spacing
  parseOptions: {
    preserveWhitespace: 'full',
  },
  onUpdate({ editor }) {
    const html = editor.getHTML()
    currentContent.value = html
    emit('update:content', html)
  },
  // Configure editor behavior for spacing
  editorProps: {
    handleKeyDown: (view, event) => {
      // Handle Shift+Enter for line breaks
      if (event.key === 'Enter' && event.shiftKey) {
        editor.value.commands.setHardBreak()
        return true
      }
      return false
    },
  },
})

// SMART LINK FUNCTION - FIX URL VALIDATION
function addLink() {
  const url = window.prompt('Masukkan URL (contoh: www.google.com atau https://google.com)')
  if (url && url.trim()) {
    const cleanUrl = url.trim()
    let finalUrl = cleanUrl
    
    // Smart URL validation and formatting
    if (isValidUrl(cleanUrl)) {
      // Already a valid full URL, use as is
      finalUrl = cleanUrl
    } else if (cleanUrl.includes('.') && !cleanUrl.includes(' ')) {
      // Looks like a domain (www.google.com, google.com, etc.)
      if (cleanUrl.startsWith('www.') || !cleanUrl.includes('://')) {
        finalUrl = 'https://' + cleanUrl
      }
    } else {
      // Invalid URL, show error and retry
      alert('URL tidak valid! Contoh yang benar:\n• www.google.com\n• https://google.com\n• google.com')
      return
    }
    
    console.log(`Original: ${cleanUrl} → Final: ${finalUrl}`)
    
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: finalUrl }).run()
  }
}

// URL validation helper
function isValidUrl(string) {
  try {
    new URL(string)
    return true
  } catch (_) {
    return false
  }
}

function addImage() {
  const url = window.prompt('Masukkan URL gambar (harus dimulai dengan http:// atau https://)')
  if (url && url.trim()) {
    const cleanUrl = url.trim()
    
    // Validate image URL
    if (isValidUrl(cleanUrl) && cleanUrl.match(/\.(jpeg|jpg|gif|png|svg|webp)(\?.*)?$/i)) {
      editor.value.chain().focus().setImage({ src: cleanUrl }).run()
    } else if (isValidUrl(cleanUrl)) {
      // Valid URL but might not be image, allow it anyway
      editor.value.chain().focus().setImage({ src: cleanUrl }).run()
    } else {
      alert('URL gambar tidak valid! Harus dimulai dengan http:// atau https://')
    }
  }
}

// Add explicit line break
function addLineBreak() {
  editor.value.chain().focus().setHardBreak().run()
}

// Add empty paragraph for spacing
function addEmptyParagraph() {
  editor.value.chain().focus().splitBlock().run()
}

// Sync prop changes from parent
watch(
  () => props.content,
  (newContent) => {
    if (editor.value && newContent !== editor.value.getHTML()) {
      editor.value.commands.setContent(newContent || `<p>${props.placeholder}</p>`)
      currentContent.value = newContent || ''
    }
  }
)

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>

<style scoped>
.filament-style-editor {
  @apply border border-gray-300 rounded-lg bg-white shadow-sm;
}

.editor-toolbar {
  @apply flex flex-wrap items-center gap-1 p-3 border-b border-gray-200 bg-gray-50;
}

.toolbar-group {
  @apply flex items-center gap-1;
}

.toolbar-divider {
  @apply w-px h-6 bg-gray-300 mx-1;
}

.editor-toolbar button {
  @apply inline-flex items-center justify-center w-8 h-8 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors;
}

.editor-toolbar button.active {
  @apply bg-blue-50 border-blue-300 text-blue-700;
}

.link-button:hover {
  @apply bg-green-50 border-green-300 text-green-700;
}

.filament-editor-content {
  @apply min-h-[200px] p-4;
}

.editor-footer {
  @apply px-4 py-2 border-t border-gray-200 bg-gray-50 flex justify-between items-center;
}

.kbd {
  @apply px-1 py-0.5 text-xs bg-gray-200 border border-gray-300 rounded;
}

/* Editor Content Styles - WITH PROPER SPACING */
:deep(.ProseMirror) {
  @apply outline-none;
  white-space: pre-wrap; /* Preserve whitespace and line breaks */
  line-height: 1.6;
}

:deep(.ProseMirror h1) {
  @apply text-3xl font-bold mb-6 mt-6 text-gray-900;
  line-height: 1.2;
}

:deep(.ProseMirror h2) {
  @apply text-2xl font-bold mb-4 mt-5 text-gray-900;
  line-height: 1.3;
}

:deep(.ProseMirror h3) {
  @apply text-xl font-bold mb-3 mt-4 text-gray-900;
  line-height: 1.4;
}

:deep(.ProseMirror p) {
  @apply mb-4;
  line-height: 1.6;
  min-height: 1.5em; /* Ensure empty paragraphs have height */
}

/* Allow empty paragraphs to show */
:deep(.ProseMirror p:empty::before) {
  content: '\200B'; /* Zero-width space to make empty paragraphs visible */
  color: transparent;
}

:deep(.ProseMirror ul) {
  @apply list-disc pl-6 mb-4 space-y-2;
}

:deep(.ProseMirror ol) {
  @apply list-decimal pl-6 mb-4 space-y-2;
}

:deep(.ProseMirror li) {
  @apply mb-1;
  line-height: 1.6;
}

:deep(.ProseMirror blockquote) {
  @apply border-l-4 border-blue-300 pl-4 italic my-6 bg-blue-50 py-3;
  line-height: 1.6;
}

:deep(.ProseMirror code) {
  @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono text-pink-600;
}

:deep(.ProseMirror img) {
  @apply max-w-full h-auto rounded shadow-sm my-4;
}

:deep(.ProseMirror hr) {
  @apply border-t-2 border-gray-300 my-8;
}

:deep(.ProseMirror a) {
  @apply text-blue-600 hover:text-blue-800 underline;
  word-break: break-all; /* Break long URLs */
}

:deep(.ProseMirror strong) {
  @apply font-semibold;
}

:deep(.ProseMirror em) {
  @apply italic;
}

:deep(.ProseMirror s) {
  @apply line-through;
}

/* Hard breaks (line breaks) */
:deep(.ProseMirror br) {
  content: '\A';
  white-space: pre;
}

/* Spacing utilities */
:deep(.ProseMirror .editor-paragraph) {
  margin-bottom: 1rem;
}

:deep(.ProseMirror .editor-break) {
  margin: 0;
}
</style>
