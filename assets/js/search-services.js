document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchServices");
    const serviceCards = document.querySelectorAll(".service-card");
    const noResults = document.getElementById("noResults");
    
    if (searchInput) {
        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();
            let visibleCount = 0;
            
            serviceCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(filter)) {
                    card.parentElement.style.display = "";
                    visibleCount++;
                } else {
                    card.parentElement.style.display = "none";
                }
            });
            
            // Show/hide empty state message
            if (noResults) {
                if (visibleCount === 0) {
                    noResults.style.display = "block";
                } else {
                    noResults.style.display = "none";
                }
            }
        });
    }
});
