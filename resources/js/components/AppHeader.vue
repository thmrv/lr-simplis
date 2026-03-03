<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Folder, LayoutGrid, Menu, Search } from 'lucide-vue-next';
import { computed, toRaw } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { getInitials } from '@/composables/useInitials';

import { toUrl } from '@/lib/utils';
import type { BreadcrumbItem, NavItem } from '@/types';

const page = usePage();

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

let t = (key: string = '...'): string => {
    if (typeof toRaw(page.props.translations)[key] != 'undefined') {
        return toRaw(page.props.translations)[key][page.props.localeKey];
    } else if (typeof toRaw(page.props.defaults)[key] != 'undefined') {
        return toRaw(page.props.defaults)[key];
    }
    return key;
};

//const getTranslation = (key: any) => toRaw(page.props.translations)[key][page.props.localeKey] || toRaw(page.props.defaults)[key] || key;

const appName = import.meta.env.VITE_APP_NAME || 'Симплис';
const docTitle = import.meta.env.DOC_TITLE || 'Безупречный образ вашей компании';

const auth = computed(() => page.props.auth);
const { isCurrentUrl, whenCurrentUrl } = useCurrentUrl();

const activeItemStyles =
    'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100';

const rightNavItems: NavItem[] = [
    {
        title: t('nav_about'),
        href: '#about',
    },
    {
        title: t('nav_cases'),
        href: '#cases',
    },
    {
        title: t('nav_services'),
        href: '#services',
    },
    {
        title: t('nav_reviews'),
        href: '#reviews',
    },
    {
        title: t('nav_contacts'),
        href: '#contacts',
    },
];
</script>

<template>
    <div>
        <div class="navbar-outer w-full">
            <div class="navbar mx-auto flex h-32 items-center p-8 mx-8 md:max-w-12xl w-full mix-blend-difference">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-9 w-9">
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <Link v-for="item in mainNavItems" :key="item.title" :href="item.href"
                                        class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                        :class="whenCurrentUrl(
                                            item.href,
                                            activeItemStyles,
                                        )
                                            ">
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5 antialiased" />
                                        {{ item.title }}
                                    </Link>
                                </nav>
                                <div class="flex flex-col space-y-4">
                                    <a v-for="item in rightNavItems" :key="item.title" :href="toUrl(item.href)"
                                        target="_blank" rel="noopener noreferrer"
                                        class="flex items-center space-x-2 text-sm font-medium">
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5" />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link href="#" class="flex items-center gap-x-2">
                    <AppLogo :title="t('app_name')"/>
                </Link>

                <div class="ml-auto flex items-center">
                    <div class="relative flex items-center">
                        <div class="hidden lg:flex flex items-center space-x-12">
                            <template v-for="item in rightNavItems" :key="item.title">
                                <a class="nav-link navigation-right-link text-xl mx-16 font-normal" :href="toUrl(item.href)"
                                    rel="noopener noreferrer">{{ item.title }}</a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="props.breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
