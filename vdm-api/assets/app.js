/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import Notif from 'notifjs';
import 'notifjs/dist/notif.min.css';

// Create an instance of Notif
const notif = new Notif(5000);

const eventSource = new EventSource('http://mercure.vdm.local/.well-known/mercure?topic=bookings.confirmed');
eventSource.onmessage = (event) => {
	const data = JSON.parse(event.data);
	notif.success(`🛒 Une nouvelle réservation vient d'arriver <b>#${data.id}</b>`);
};
