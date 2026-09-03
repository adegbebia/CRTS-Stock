import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import swal from 'sweetalert';
import Typed from 'typed.js';

// Expose ces libs en global comme le faisaient les <script> CDN,
// pour ne pas avoir à réécrire tout le code des vues Blade.
window.Alpine = Alpine;
window.Swal = Swal;
window.swal = swal;
window.Typed = Typed;

Alpine.start();
