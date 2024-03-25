<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Meeting Zoom') }}
        </h2>
    </x-slot>

    <div style="margin-left: 20px;">
        <form action="{{ route('zoom.store') }}" method="POST">
            @csrf
            <br>

            {{-- <label for="agenda" style="color: white;">Agenda:</label>
            <input type="text" id="agenda" name="agenda" value="your agenda">
            <br><br>

            <label for="topic" style="color: white;">Topic:</label>
            <input type="text" id="topic" name="topic" value="your topic">
            <br><br>

            <label for="type" style="color: white;">Type:</label>
            <input type="number" id="type" name="type" value="2">
            <br><br>

            <label for="duration" style="color: white;">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" value="60">
            <br><br>

            <label for="timezone" style="color: white;">Timezone:</label>
            <input type="text" id="timezone" name="timezone" value="Asia/Dhaka">
            <br><br>

            <label for="password" style="color: white;">Password:</label>
            <input type="password" id="password" name="password" value="set your password">
            <br><br>

            <label for="start_time" style="color: white;">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time" value="{{ date('Y-m-d\TH:i') }}">
            <br><br>

            <label for="template_id" style="color: white;">Template ID:</label>
            <input type="text" id="template_id" name="template_id" value="set your template id">
            <br><br>

            <label for="pre_schedule" style="color: white;">Pre-schedule:</label>
            <input type="checkbox" id="pre_schedule" name="pre_schedule" value="1">
            <br><br>

            <label for="schedule_for" style="color: white;">Schedule For:</label>
            <input type="email" id="schedule_for" name="schedule_for" value="set your schedule for profile email">
            <br><br>

            <label for="join_before_host" style="color: white;">Join Before Host:</label>
            <input type="checkbox" id="join_before_host" name="join_before_host" value="1">
            <br><br>

            <label for="host_video" style="color: white;">Host Video:</label>
            <input type="checkbox" id="host_video" name="host_video" value="1">
            <br><br>

            <label for="participant_video" style="color: white;">Participant Video:</label>
            <input type="checkbox" id="participant_video" name="participant_video" value="1">
            <br><br>

            <label for="mute_upon_entry" style="color: white;">Mute Upon Entry:</label>
            <input type="checkbox" id="mute_upon_entry" name="mute_upon_entry" value="1">
            <br><br>

            <label for="waiting_room" style="color: white;">Waiting Room:</label>
            <input type="checkbox" id="waiting_room" name="waiting_room" value="1">
            <br><br> --}}

            <label for="audio" style="color: white;">Audio:</label>
            <select id="audio" name="audio">
                <option value="both" selected>Both</option>
                <option value="telephony">Telephony</option>
                <option value="voip">VOIP</option>
            </select>
            <br><br>

            <label for="auto_recording" style="color: white;">Auto Recording:</label>
            <select id="auto_recording" name="auto_recording">
                <option value="none" selected>None</option>
                <option value="local">Local</option>
                <option value="cloud">Cloud</option>
            </select>
            <br><br>

            <label for="approval_type" style="color: white;">Approval Type:</label>
            <select id="approval_type" name="approval_type">
                <option value="0" selected>Automatically Approve</option>
                <option value="1">Manually Approve</option>
                <option value="2">No Registration Required</option>
            </select>
            <br><br>
        <div style="margin-left: 45%;">
            <button
                style="color: white; background-color: #50c779; padding: 10px 20px; border: none; cursor: pointer;">Почати
                дзвінок</button>
        </div>
        <br>
    </form>
</x-app-layout>
