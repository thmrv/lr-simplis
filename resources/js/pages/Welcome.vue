<script setup lang="ts">
import { App, Head, Link, usePage } from '@inertiajs/vue3';
import { computed, toRaw } from 'vue';
import AppHeader from '@/components/AppHeader.vue';
import LoadingShutter from '@/components/LoadingShutter.vue';
import ShowreelTrackable from '@/components/ShowreelTrackable.vue';
import ShutterText from '@/components/ShutterText.vue';

import { toUrl } from '@/lib/utils';
import TextTrackable from '@/components/TextTrackable.vue';
import TextZoomable from '@/components/TextZoomable.vue';
const page = usePage();

let t = (key: string = '...'): string => {
    if (typeof toRaw(page.props.translations)[key] != 'undefined') {
        return toRaw(page.props.translations)[key][page.props.localeKey];
    } else if (typeof toRaw(page.props.defaults)[key] != 'undefined') {
        return toRaw(page.props.defaults)[key];
    }
    return key;
};

let split = (string: string): string[] => {
    return string.split(' ');
};

const appName = import.meta.env.VITE_APP_NAME || 'Симплис';
</script>

<template>
    <LoadingShutter></LoadingShutter>

    <Head>
    </Head>
    <AppHeader></AppHeader>

    <div class="masthead-wrapper p-8 flex flex-col justify-between gap-y-12 bg-white pt-32">
        <div class="masthead-inner masthead-upper p-8 flex md:flex-row flex-col items-top justify-between">
            <div class="masthead-showreel-wrapper flex flex-col w-3/12 gap-y-2">
                <ShowreelTrackable :caption="t('masthead_showreel')"></ShowreelTrackable>
            </div>
            <div class="masthead-title-wrapper w-full md:w-7/12 ">
                <div class="masthead-title-inner">
                    <div
                        class="masthead-title text-9xl font-black uppercase subpixel-antialiased flex flex-row flex-wrap gap-x-6 tracking-light overflow-visible">
                        <ShutterText v-for="(word, i) in split(t('masthead_title'))" :key="i" :delay="`${i * 0.05}s`"
                            class="subpixel-antialiased w-max">
                            {{ word }}
                        </ShutterText>
                    </div>
                </div>
            </div>
        </div>
        <div class="masthead-inner masthead-lower flex md:flex-row flex-col gap-x-8 justify-between">
            <div class="masthead-subtitle-wrapper md:w-4/12 w-full flex flex-row flex-wrap gap-x-4">
                <ShutterText v-for="(word, i) in split(t('masthead_subtitle'))" :key="i" :delay="`${i * 0.05}s`"
                    class="masthead-subtitle font-normal text-6xl subpixel-antialiased w-max tracking-light">
                    {{ word }}
                </ShutterText>
            </div>
            <div class="masthead-links-wrapper flex flex-row w-6/12 gap-x-8 justify-between items-end">
                <a class="btn-link text-2xl flex flex-row gap-x-2 items-center font-light antialiased " href="#about"
                    target="_blank" rel="noopener noreferrer">
                    {{ t('masthead_action_about') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 4.5 15 15m0 0V8.25m0 11.25H8.25" />
                    </svg>
                </a>
                <a class="btn-link text-2xl flex flex-row gap-x-2 items-center font-light antialiased " href="#about"
                    target="_blank" rel="noopener noreferrer">
                    {{ t('masthead_action_explore') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 4.5 15 15m0 0V8.25m0 11.25H8.25" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="about-outer overflow-hidden" id="about">
        <div class="about-wrapper p-8 flex flex-col justify-between min-h-screen gap-y-12 bg-darkcyan">
            <TextTrackable :color="'white'" :text="t('about_text_large')"></TextTrackable>
            <div class="about-cards-wrapper flex flex-col flex-wrap gap-8 items-end">
                <div class="about-card flex flex-col gap-y-4 lg:w-6/12">
                    <p class="about-card-title text-lg font-normal">{{ t('about_card_about_us_title') }}</p>
                    <p class="about-card-content text-md font-normal">{{ t('about_card_about_us_content') }}</p>
                </div>
                <div class="about-card flex flex-col gap-y-4 lg:w-6/12">
                    <p class="about-card-title text-lg font-normal">{{ t('about_card_ideals_title') }}</p>
                    <p class="about-card-content text-md font-normal">{{ t('about_card_ideals_content') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="cases-wrapper-scroller" id="cases">
        <TextZoomable :color="'black'" :text="t('cases_text_large')"></TextZoomable>
    </div>
    <div class="cases-wrapper p-8 flex flex-row flex-wrap justify-between min-h-screen gap-12 bg-dark">
        <div class="case-outer flex items-start gap-4 flex-col w-4/12 h-200">
            <div class="case-title text-white font-sm">{{ t('case_title_1') }}</div>
            <div class="case-wrapper flex items-center justify-center h-full w-full bg-neutral-900"></div>
        </div>
        <div class="case-outer flex items-start gap-4 flex-col w-3/12 h-100">
            <div class="case-title text-white font-sm">{{ t('case_title_2') }}</div>
            <div class="case-wrapper flex items-center justify-center h-full w-full bg-neutral-900"></div>
        </div>
        <div class="case-outer flex items-start gap-4 flex-col w-3/12 h-100">
            <div class="case-title text-white font-sm">{{ t('case_title_3') }}</div>
            <div class="case-wrapper flex items-center justify-center h-full w-full bg-neutral-900"></div>
        </div>
    </div>
    <div class="branding-wrapper p-8 flex flex-col justify-between gap-y-12">

    </div>
    <div class="services-wrapper p-8 flex flex-col justify-between gap-y-12" id="services">

    </div>
    <div class="reviews-wrapper p-8 flex flex-col justify-between gap-y-12" id="reviews">

    </div>
    <div class="contacts-wrapper p-8 flex flex-col justify-between gap-y-12" id="contacts">

    </div>
    <div class="footer-wrapper p-8 flex flex-col justify-between gap-y-12">

    </div>
</template>
