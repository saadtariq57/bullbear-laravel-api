<template>
    <div class="container my-4">
    <div class="personal-head text-center border-bottom mb-4">
        <h1 class="fs-2 fw-6">Personal Access</h1>
    </div>
    <div class="personal-card-wrapper row">
        <div class="col-md-6">
            <div class="card flex-fill shadow-sm border">
                <div class="card-body text-center">
                    <i class="bi bi-calendar3 fs-2"></i>
                    <h2 class="fs-4 fw-5">Book An Appointment</h2>
                    <p>Booking an appointment with a professional guarantees personalized assistance and efficient
                        problem-solving.</p>
                    <button class="btn btn-primary">Select</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-fill shadow-sm border">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots fs-2"></i>
                    <h2 class="fs-4 fw-5">Chat With Professionals</h2>
                    <p>Chatting with a professional provides convenient access to tailored expertise and guidance in
                        real-time</p>
                    <button class="btn btn-primary">Select</button>
                </div>
            </div>
        </div>
    </div>
    <div class="personal-form-wrapper d-flex justify-content-center mt-3">
        <form class="w-50 border p-3 shadow-sm">
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Name</label>
                <input type="text" class="form-control border shadow-sm" id="exampleInputName">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control border shadow-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputDate" class="form-label">Date</label>
                <input type="date" class="form-control border shadow-sm" id="exampleInputDate">
            </div>
            <div class="mb-3">
                <label for="exampleInputTime" class="form-label">Time</label>
                <input type="time" class="form-control border shadow-sm" id="exampleInputTime">
            </div>
            <button type="submit" class="btn btn-primary">Schedule</button>
        </form>
    </div>
</div>
</template>
<style>
.personal-form-wrapper form{
    width: 50%;
}
</style>