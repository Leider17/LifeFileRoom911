<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="240.000000pt" height="220.000000pt" viewBox="0 0 240.000000 220.000000"
 preserveAspectRatio="xMidYMid meet">

<g transform="translate(0.000000,220.000000) scale(0.100000,-0.100000)"
fill="#000000" stroke="none">
<path d="M1079 2149 c-268 -28 -530 -174 -705 -393 -81 -101 -165 -269 -200
-401 -25 -90 -27 -117 -27 -265 0 -146 3 -177 27 -265 110 -417 450 -728 866
-791 413 -62 806 103 1042 436 229 325 260 747 80 1105 -155 310 -473 532
-822 575 -94 11 -149 11 -261 -1z m175 -631 c8 -13 62 -151 121 -308 58 -157
108 -292 111 -300 3 -9 22 29 44 88 21 56 43 109 50 117 10 12 38 15 131 15
l119 0 0 -45 0 -45 -98 0 -98 0 -53 -145 c-57 -155 -74 -178 -109 -147 -13 10
-64 133 -130 312 -60 162 -112 301 -114 309 -2 8 -44 -93 -93 -225 -142 -384
-146 -394 -165 -404 -31 -17 -50 11 -104 155 l-52 140 -87 3 -87 3 0 44 0 45
103 0 c67 0 109 -4 119 -12 9 -7 33 -59 53 -116 21 -57 39 -102 40 -100 2 2
20 48 40 103 43 117 126 340 163 440 14 39 30 76 35 83 15 19 45 14 61 -10z"/>
</g>
</svg>
</template>
