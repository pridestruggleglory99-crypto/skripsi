<button
    id="backToTop"
    class="hidden fixed bottom-6 right-6 z-50 h-12 w-12 items-center justify-center rounded-full bg-indigo-600 text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-indigo-700 hover:shadow-xl"
    aria-label="Back to Top"
>
    <svg xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
    </svg>
</button>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('backToTop');

    if (!button) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            button.classList.remove('hidden');
            button.classList.add('flex');
        } else {
            button.classList.remove('flex');
            button.classList.add('hidden');
        }
    });

    button.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>