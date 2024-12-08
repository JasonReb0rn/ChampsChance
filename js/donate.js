document.addEventListener('DOMContentLoaded', (event) => {

    // Handle donation frequency buttons
    document.querySelectorAll('.freq-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.freq-button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('donate-frequency').value = this.getAttribute('data-frequency');

            /*
            var customAmountTextbox = document.getElementById('donate-custom-amount-text');

            if (this.getAttribute('data-frequency') === 'monthly') {
                customAmountTextbox.style.display = 'none';
            } else {
                customAmountTextbox.style.display = 'flex';
            }
            */

        });
    });


    // Handle textbox clearing price buttons
    const customAmountInput = document.getElementById('donate-custom-amount');
    if (customAmountInput) {
        customAmountInput.addEventListener('input', () => {
            //console.log('Custom amount entered:', customAmountInput.value);
            customAmountInput.value = customAmountInput.value.replace(/[^\d.]/g, '');

            document.querySelectorAll('.amount-button').forEach(btn => btn.classList.remove('active'));
        });
    } else {
        console.error('Custom amount input element not found');
    }


    // Handle price buttons
    document.querySelectorAll('.amount-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.amount-button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('donate-amount').value = this.getAttribute('data-amount');

            document.getElementById('donate-custom-amount').value = this.getAttribute('data-amount');
        });
    });

    
    // Handle checkbox
    document.getElementById('dedication-checkbox').addEventListener('change', function() {
        var dedicationText = document.getElementById('donate-dedication-text');
        if (this.checked) {
            dedicationText.style.display = 'block';
        } else {
            dedicationText.style.display = 'none';
        }
    });
    

});