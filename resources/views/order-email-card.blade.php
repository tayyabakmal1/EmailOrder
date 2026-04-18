<div class="card mb-3">
    <div class="card-header">
        <strong>Send Email to Customer</strong>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <label for="email-order-message">Message</label>
            <textarea id="email-order-message" class="form-control" rows="5"></textarea>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <button class="btn btn-primary" id="email-order-send">Send Email</button>
            <button class="btn btn-secondary" id="email-order-save">Save Message Only</button>
            <span id="email-order-loader" style="display:none;">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...
            </span>
        </div>
    </div>
    <div class="card-footer" id="email-order-latest-message">
        <em>Loading latest message...</em>
    </div>
</div>
<script>
(function() {
    const orderId = {{ $order->id }};
    const messageTextarea = document.getElementById('email-order-message');
    const latestMessageDiv = document.getElementById('email-order-latest-message');
    const loader = document.getElementById('email-order-loader');

    // Fetch latest message
    function loadLatest() {
        fetch(`/admin/email-order/order/${orderId}/latest`)
            .then(res => res.json())
            .then(data => {
                if (data.latest) {
                    latestMessageDiv.innerHTML = `<strong>Last Message (${data.latest.template_used || 'Custom'}):</strong><br>${data.latest.message_content}<br><span class='badge bg-info'>${data.latest.status}</span>`;
                } else {
                    latestMessageDiv.innerHTML = '<em>No messages yet.</em>';
                }
            });
    }
    loadLatest();

    // Send or Save
    function sendOrSave(action) {
        loader.style.display = 'inline-block';
        fetch(`/admin/email-order/order/${orderId}/send-or-save`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: messageTextarea.value,
                template: '',
                action: action
            })
        })
        .then(res => res.json())
        .then(data => {
            loader.style.display = 'none';
            if (data.success) {
                loadLatest();
                if (typeof Botble !== 'undefined' && typeof Botble.showSuccess === 'function') {
                    Botble.showSuccess(action === 'send' ? 'Email sent successfully!' : 'Message saved successfully!');
                }
            }
        })
        .catch(() => {
            loader.style.display = 'none';
        });
    }
    document.getElementById('email-order-send').onclick = function() { sendOrSave('send'); };
    document.getElementById('email-order-save').onclick = function() { sendOrSave('save'); };
})();
</script> 