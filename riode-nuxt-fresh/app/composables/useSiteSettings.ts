export type SiteSettings = {
  site_name: string
  site_logo_url: string | null
  site_logo_wide_url: string | null
  auth_google_enabled?: boolean
}

const fallbackSettings: SiteSettings = {
  site_name: 'Riode',
  site_logo_url: null,
  site_logo_wide_url: null,
  auth_google_enabled: false
}

export const useSiteSettings = () => {
  const config = useRuntimeConfig()
  const cached = useState<SiteSettings>('site-settings-cache', () => fallbackSettings)
  const loaded = useState<boolean>('site-settings-loaded', () => false)

  const fetchSettings = async () => {
    const payload = await $fetch<SiteSettings>(`${config.public.apiBase}/settings`)
    cached.value = {
      site_name: payload.site_name || fallbackSettings.site_name,
      site_logo_url: payload.site_logo_url ?? null,
      site_logo_wide_url: payload.site_logo_wide_url ?? null,
      auth_google_enabled: payload.auth_google_enabled ?? false
    }
    loaded.value = true
    return cached.value
  }

  const { data, pending, error, refresh } = useAsyncData('site-settings', fetchSettings, {
    immediate: !loaded.value,
    default: () => cached.value
  })

  const settings = computed(() => cached.value.site_name ? cached.value : data.value || fallbackSettings)

  return {
    settings,
    pending,
    error,
    refreshSettings: refresh
  }
}
