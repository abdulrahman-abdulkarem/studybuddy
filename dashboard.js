document.addEventListener('DOMContentLoaded', () => {
    const bookingsContainer = document.querySelector('.users .card-container');
    const userRole = document.querySelector('body').getAttribute('data-role'); // Assuming the role is set as a data attribute

    fetch('fetch_dashboard_data.php')
        .then(response => response.json())
        .then(data => {
            const items = data.data;

            items.forEach(item => {
                const card = createCard(item, userRole);
                bookingsContainer.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });

    function createCard(item, role) {
        const card = document.createElement('div');
        card.className = 'card';
        let statusColor = 'grey';
        if (item.status === 'Accepted') {
            statusColor = 'green';
        } else if (item.status === 'Rejected') {
            statusColor = 'red';
        }

        card.innerHTML = `
            <img src="path/to/profile/photo" alt="Profile Photo">
            <h4>${role === 'student' ? item.tutor_name : item.student_name}</h4>
            <p>${item.course_name}</p>
            <p>Status: <span style="color: ${statusColor}">${item.status}</span></p>
            ${role === 'tutor' && item.status === 'Pending' ? `
            <button class="accept_btn" data-request-id="${item.id}">Accept</button>
            <button class="reject_btn" data-request-id="${item.id}">Reject</button>
            ` : ''}
            ${role === 'student' && item.status === 'Accepted' ? '<button class="contact_btn">Contact Tutor</button>' : ''}
        `;

        if (role === 'tutor' && item.status === 'Pending') {
            card.querySelector('.accept_btn').addEventListener('click', () => {
                updateRequestStatus(item.id, 'Accepted', card);
            });

            card.querySelector('.reject_btn').addEventListener('click', () => {
                updateRequestStatus(item.id, 'Rejected', card);
            });
        }

        return card;
    }

    function updateRequestStatus(requestId, status, card) {
        fetch('update_request_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ request_id: requestId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                card.querySelector('span').textContent = status;
                card.querySelector('span').style.color = status === 'Accepted' ? 'green' : 'red';
                card.querySelector('.accept_btn').remove();
                card.querySelector('.reject_btn').remove();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
