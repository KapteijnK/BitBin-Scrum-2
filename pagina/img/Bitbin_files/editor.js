const editor = document.querySelector('#code-editor');
const lineNumbers = document.querySelector('#line-numbers');

function highlightLine() {
    const activeLine = editor.value.slice(0, editor.selectionStart).split('\n').length - 1;
    const totalLines = editor.value.split('\n').length;

    lineNumbers.innerHTML = Array.from({ length: totalLines }, (_, index) => `
        <li class="${index === activeLine ? 'bg-(--color-primary)/15 text-(--color-accent)' : ''} px-4">
            <span class="inline-block w-8 text-right">${String(index + 1).padStart(2, '0')}</span>
        </li>
    `).join('');
}

editor.addEventListener('input', highlightLine);
editor.addEventListener('click', highlightLine);
editor.addEventListener('keyup', highlightLine);
editor.addEventListener('scroll', () => lineNumbers.style.transform = `translateY(-${editor.scrollTop}px)`);

highlightLine();
