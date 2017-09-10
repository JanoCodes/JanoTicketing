<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

return [

    /**
     * System Languages
     */
    'about' => 'About',
    'about_copyright' => '&copy; Andrew Ying and contributors 2016-17.',
    'about_license' => 'Jano Ticketing System is free software: you can redistribute it and/or modify it'
        . ' under the terms of the <a href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank"'
        . '>GNU General Public License v3.0</a>. You <b>must</b> preserve all legal notices and author '
        . 'attributions present.',
    'account' => 'Your Account',
    'accepted_file_types' => 'Accepted file type(s): :extensions',
    'access_level' => 'Access Level',
    'add_attendee' => 'Add Attendee',
    'agreement' => 'Agreement',
    'amount_due' => 'Amount Due',
    'amount_outstanding' => 'Amount Outstanding',
    'amount_paid' => 'Amount Paid',
    'attendee' => 'Attendee',
    'attendees' => 'Attendees',
    'attendee_cancel' => 'Cancel Ticket',
    'back' => 'Back',
    'cancel_alert' => 'Are you sure that you would like to cancel this :attribute?',
    'cancel_order' => 'Cancel Order',
    'cancel_small' => 'This action is irreversible and so cannot be undone.',
    'charges' => 'Charges',
    'collection_edit' => 'Edit Proxy Information',
    'confirm_password' => 'Confirm Password',
    'continue' => 'Continue',
    'copyright' => 'Copyright &copy; Andrew Ying 2016-17. Licensed under the '
        . '<a href="https://github.com/jano-may-ball/ticketing/blob/master/LICENSE.md" target="_blank">'
        . 'GNU General Public License v3.0</a>.',
    'currency' => 'Currency',
    'create_order' => 'Create Order',
    'create_payment' => 'Create Payment',
    'create_staff' => 'Create Staff',
    'date_credited' => 'Date Credited',
    'days' => 'day(s)',
    'delete' => 'Delete',
    'description' => 'Description',
    'donation' => 'Optional Charity Donation',
    'edit' => 'Edit Entry',
    'email' => 'Email Address',
    'exception_title' => 'Something went wrong...',
    'exception_message' => 'It looks like someone messed with the wires and now the system stopped working. We\'ve '
        . 'alerted an administrator and they should fix the issue very soon!',
    'event_name' => 'Event Name',
    'first_name' => 'First Name',
    'for' => 'for',
    'form_error' => 'There was an error in the order form. Please try again.',
    'forgot_your_password' => 'Forgot Your Password?',
    'first_choice_ticket' => 'First Choice Ticket Type',
    'full_name' => 'Full Name',
    'group' => 'Group',
    'home' => 'Home',
    'import_entries' => 'Import Entries',
    'internal_reference' => 'Internal Reference',
    'jano_ticketing_system' => 'Jano Ticketing System',
    'last_name' => 'Last Name',
    'login' => 'Login',
    'logout' => 'Logout',
    'method' => 'Method',
    'new_entry' => 'New Entry',
    'new_password' => 'New Password',
    'next' => 'Next',
    'no_ticket_type_exists' => 'No ticket type exists for this event.',
    'order' => 'Order',
    'order_confirmed' => 'Order Confirmed',
    'order_summary' => 'Order Summary',
    'order_tickets' => 'Order Tickets',
    'original_attendee' => 'Original Attendee',
    'new_attendee' => 'New Attendee',
    'password' => 'Password',
    'payments' => 'Payments',
    'payment_due' => 'Payment Due',
    'payment_information' => 'Payment Information',
    'payment_methods' => [
        'bacs' => 'Bank Transfer',
        'manual' => 'Cash',
        'discount' => 'Discount/Credit',
    ],
    'phone' => 'Phone Number',
    'price' => 'Price',
    'primary_ticket_holder' => 'Primary ticket holder',
    'processing_order_title' => 'Processing Order',
    'processing_order_message' => 'We are currently processing your order. Please do not refresh this window. You will '
        . 'be redirected automatically when your order is confirmed.',
    'quantity' => 'Quantity',
    'unable_to_process_order_title' => 'Unable to Process Order',
    'unable_to_process_order_message' => 'An unexcepted system issue prevents us from processing your order at this '
        . 'moment. Please try again later. We apologise for the inconvenience and please feel free to contact us if you'
        . ' require any assistance.',
    'unique_id' => 'Unique ID',
    'unique_id_regeneration_queued' => 'Unique ID regeneration queued',
    'upload_files_prompt' => 'Drag files here to upload',
    'reference' => 'Reference',
    'regenerate' => 'Regenerate',
    'register' => 'Register',
    'remember_me' => 'Remember Me',
    'request_create' => 'Create Waiting List Entry',
    'request_created' => 'Waiting List Entry Created',
    'request_created_message' => 'You have successfully submitted an entry to the waiting list. The details of the '
        . 'entry are supplied below for your reference. You would be notified via email should a ticket becomes '
        . 'available.',
    'request_edit' => 'Edit Waiting List Entry',
    'reset' => 'Reset',
    'reset_password' => 'Reset Password',
    'search' => 'Search',
    'send_password_reset_link' => 'Send Password Reset Link',
    'settings' => 'Settings',
    'slash' => '/',
    'soldout' => 'Sold Out',
    'submit' => 'Submit',
    'staff' => 'Staff',
    'status' => 'Status',
    'system_title' => 'System Title',
    'terms' => 'Terms',
    'ticket_limit_reached' => 'You have reached the number of tickets you are allowed to purchase.',
    'ticket_order_for_attendee' => 'Ticket order for :count attendee|Ticket order for :count attendees',
    'ticket_orders' => 'Ticket Orders',
    'ticket_transfer_request' => 'Ticket Transfer Request',
    'ticket_transfer_order' => 'Order for ticket transfer',
    'tickets_unavailable_title' => 'Unable to reserve tickets',
    'tickets_unavailable_message' => 'All tickets are currently reserved. Tickets may be released if other patrons fail'
        . ' to complete their transactions within 15 minutes. Please try again later.',
    'tickets_partly_unavailable_title' => 'Unable to reserve all tickets requested',
    'tickets_partly_unavailable_message' => 'Please check the order summary to the right for the number of tickets the '
        . 'system was able to reserve for you, and either continue with or cancel your order as appropriate.',
    'time_for_payment' => 'Time for Payment',
    'title' => 'Title',
    'titles' => [
        0 => 'Mr',
        1 => 'Ms',
        2 => 'Miss',
        3 => 'Mrs',
        4 => 'Dr',
        5 => 'Prof'
    ],
    'transfer_cancel' => 'Cancel Transfer Request',
    'transfer_create' => 'Create Transfer Request',
    'transfer_created' => 'Transfer Request Created',
    'transfer_created_details' => 'Your ticket transfer request have now been created. You should receive an email '
        . 'with information about the next step soon. Please ensure that the instructions are being followed as '
        . 'we cannot otherwise process your request.',
    'transfer_edit' => 'Edit Transfer Request',
    'type' => 'Ticket Type',
    'update' => 'Update Entry',
    'update_primary_ticket_holder' => 'Update Primary Ticket Holder',
    'update_success' => 'Entry updated successfully',
    'upload' => 'Upload',
    'upload_column_match_message' => 'We were unable to automatically identify the column headings for {{ name }}...'
        . ' Please do the matching manually below.',
    'upload_error_message' => 'File upload failed',
    'upload_info_required_message' => 'Information required',
    'upload_manual_column_match_error' => 'The matching of column headings is invalid. Please try again.',
    'upload_success_message' => 'All files have been successfully uploaded and queued for processing! You would '
        . 'be notified when the processing is completed.',
    'user' => 'User',
    'users' => 'Users',
    'view_details' => 'View Details',
    'waiting_list' => 'Waiting List Entry',
    'welcome' => 'Welcome',
    'welcome_message' => 'Welcome to :title! To purchase your event tickets and view the status of your orders, '
        . 'please either register or login.',
    'your_details' => 'Your Details',
];
