import { ref, onMounted, onUnmounted } from 'vue';

export const useTypewriter = (text, cyanWord, typingSpeed = 100, pauseBeforeErase = 5000, restartDelay = 500) => {
  const typewriterText = ref('');
  let index = 0;
  let timeoutId;

  const type = () => {
    if (index < text.length) {
      const char = text[index];

      // Highlight the cyanWord
      if (index >= text.indexOf(cyanWord) && index < text.indexOf(cyanWord) + cyanWord.length) {
        typewriterText.value += `<span class="text-cyan-500">${char}</span>`;
      } else {
        typewriterText.value += char;
      }

      index++;
      timeoutId = setTimeout(type, typingSpeed);
    } else {
      // Pause before erasing
      timeoutId = setTimeout(erase, pauseBeforeErase);
    }
  };

  const erase = () => {
    if (typewriterText.value.length > 0) {
      // Remove the last character (including HTML tags)
      typewriterText.value = removeLastCharacter(typewriterText.value);
      // typewriterText.value = typewriterText.value.replace(/.$/, '');
      timeoutId = setTimeout(erase, typingSpeed / 2);
    } else {
      // Restart typing after delay
      index = 0;
      timeoutId = setTimeout(type, restartDelay);
    }
  };
  const removeLastCharacter = (text) => {
    if (text.endsWith('</span>')) {
      // If the last part is a closing span tag, remove it
      return text.substring(0, text.lastIndexOf('<span class="text-cyan-500">'));
    }
    return text.slice(0, -1);
  };
  onMounted(() => {
    type();
  });

  onUnmounted(() => {
    // Clear any pending timeouts when the component is unmounted
    clearTimeout(timeoutId);
  });

  return { typewriterText };
};