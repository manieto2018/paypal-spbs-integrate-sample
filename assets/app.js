window.addEventListener('DOMContentLoaded', (event) => {

    const app = {
        service: 'Private',
        amount: 39,
        payment: 'card'
    };

    // Return price per service
    function findPricing(service)
    {
        if(service == 'Private')
        {
            return 39;
        }
        if(service == 'Luxury')
        {
            return 78;
        }
    }

    // Return app data
    function getDataApp()
    {
        return app;
    }

    // Find the element active
    function findActive(list, findClass)
    {
        const els = Array.from(list);

        const active = els.filter((el_) => {
            if(el_.classList.contains(`${findClass}`))
            {
                return el_;
            }
        });

        if(active.length > 0)
        {
            removeSelected(active[0], `${findClass}`);
        }
    }

    // Remove class option selected DOM
    function removeSelected(elemnt, class_)
    {
        elemnt.classList.remove(''+class_+'');
    }

    // Total dom
    const totalDOM = document.getElementById('total');

    // Choose a service
    const optionService = document.querySelectorAll('.item-service');
    if(optionService)
    {
        optionService.forEach((el) => {
            el.addEventListener('click', (e) => {
                
                app.service = el.getAttribute('data-service');
                app.amount = findPricing(app.service);

                // Render UI
                if(totalDOM)
                {
                    totalDOM.innerHTML = `${app.amount}<b>USD</b>`;

                    // Remove selected effect
                    findActive(optionService, 'item-service-selected');

                    // Set selected
                    el.classList.add('item-service-selected');

                    // Get App data
                    console.log(getDataApp());

                }
                
            });
        });
    }

    // Choose a payment
    const optionPayment = document.querySelectorAll('.item-payment');
    if(optionPayment)
    {
        optionPayment.forEach((el) => {
            el.addEventListener('click', (e) => {

                app.payment = el.getAttribute('data-payment');

                // Remove selected effect
                findActive(optionPayment, 'item-payment-selected');


                // Se selected
                el.classList.add('item-payment-selected');

                // Get App data
                console.log(getDataApp());


            });
        });
    }

    // Booking emulate
    const bookingButton = document.getElementById('bookingButton');
    if(bookingButton)
    {
        bookingButton.addEventListener('click', (e) => {
            e.preventDefault();

            console.log(`Yeah! I want buy this:`);
            console.log(getDataApp())
            bookingButton.setAttribute('disabled', 'disabled');
            bookingButton.textContent = 'Hiring your service...';

            bookingButton.style.display = 'none';

            // Emulate fetch on our system that return invoice
            const invoice = 'ALE0001';

            // Show paypal option
            if(app.payment == 'paypal')
            {
                const paypalButton = document.getElementById('paypal-button-container');
                if(paypalButton)
                {
                    console.log(paypalButton)
                    paypalButton.classList.remove('hidden');
                }       
            }

            // Show card option
            if(app.payment == 'card')
            {
                const cardButton = document.getElementById('card-button-container');
                if(cardButton)
                {
                    cardButton.classList.remove('hidden');
                } 
            }

        });
    }

});