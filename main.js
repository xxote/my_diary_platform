document.addEventListener('DOMContentLoaded', function() {
    const empathyFormElement = document.querySelector('.empathy-form');
    if (empathyFormElement) {
        empathyFormElement.addEventListener('submit', function(event) {
            event.preventDefault();

            const formDetails = new FormData(empathyFormElement);
            fetch('add_empathy.php', {
                method: 'POST',
                body: formDetails
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const empathyCountElement = document.querySelector('.empathy-count');
                    empathyCountElement.textContent = `Empathy: ${data.empathy_count}`;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
        });
    }
});
