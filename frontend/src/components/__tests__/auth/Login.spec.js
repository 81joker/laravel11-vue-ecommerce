// src/components/__tests__/auth/Login.spec.js
import { mount, flushPromises } from '@vue/test-utils'
import { describe, it, expect, vi, beforeEach } from 'vitest'

// ✅ adjust this path if your component lives elsewhere
import Login from '../../auth/Login.vue'

// We’ll use the real value from your config for URL building.
// If you prefer, you can hardcode it in the test instead.
import { API_BASE_URL } from '../../../helpers/config'

// ---- Mocks ----
vi.mock('axios', () => ({
  default: { post: vi.fn() }
}))
import axios from 'axios'

const pushMock = vi.fn()
vi.mock('vue-router', () => ({
  useRouter: () => ({ push: pushMock })
}))

const toastSuccess = vi.fn()
const toastError = vi.fn()
vi.mock('vue-toastification', () => ({
  useToast: () => ({
    success: toastSuccess,
    error: toastError
  })
}))

// Minimal stubs for child components
const stubs = {
  Spinner: {
    template: '<div data-test="spinner"></div>',
    props: ['store']
  },
  RenderValidationErrors: {
    template: '<div data-test="rve"></div>',
    props: ['formValidationErrors']
  }
}

// Mock for Pinia store returned by useAuthStore()
const makeAuthStoreMock = () => {
  return {
    // state
    isLoading: false,
    validationErrors: {},
    // actions (spies)
    clearValidationErrors: vi.fn(),
    setValidationErrors: vi.fn(),
    setIsLoggedIn: vi.fn(),
    setUser: vi.fn(),
    setToken: vi.fn()
  }
}

let authStore
vi.mock('../../../stores/useAuthStore', () => ({
  useAuthStore: () => authStore
}))

// Utility to mount the component with fresh store each time
const factory = () =>
  mount(Login, {
    global: { stubs }
  })

describe('Login.vue', () => {
  beforeEach(() => {
    vi.clearAllMocks()
    authStore = makeAuthStoreMock()
  })

  it('renders the heading and clears validation errors on mount', async () => {
    const wrapper = factory()
    expect(wrapper.text()).toContain('Login')
    expect(authStore.clearValidationErrors).toHaveBeenCalledTimes(1)
  })

  it('submits credentials and handles a successful login', async () => {
    const wrapper = factory()

    // fill out the form
    await wrapper.get('input#email').setValue('john@example.com')
    await wrapper.get('input#password').setValue('secret123')

    // axios resolves with success payload (no "error" key)
    axios.post.mockResolvedValueOnce({
      data: {
        message: 'Logged in',
        user: { id: 1, name: 'John' },
        access_token: 'token-123'
      }
    })

    await wrapper.get('form').trigger('submit.prevent')
    // first tick updates loading, then await network, then finalize
    await flushPromises()

    expect(axios.post).toHaveBeenCalledWith(
      `${API_BASE_URL}/user/login`,
      { email: 'john@example.com', password: 'secret123' }
    )

    expect(authStore.setIsLoggedIn).toHaveBeenCalledWith(true)
    expect(authStore.setUser).toHaveBeenCalledWith({ id: 1, name: 'John' })
    expect(authStore.setToken).toHaveBeenCalledWith('token-123')
    expect(toastSuccess).toHaveBeenCalledWith('Logged in', { timeout: 2000 })
    expect(pushMock).toHaveBeenCalledWith('/')
    // final loading state should be false
    expect(authStore.isLoading).toBe(false)
  })

  it('shows a toast error when API returns an "error" message', async () => {
    const wrapper = factory()

    await wrapper.get('input#email').setValue('a@a.com')
    await wrapper.get('input#password').setValue('badpass')

    axios.post.mockResolvedValueOnce({
      data: {
        error: 'Invalid credentials'
      }
    })

    await wrapper.get('form').trigger('submit.prevent')
    await flushPromises()

    expect(toastError).toHaveBeenCalledWith('Invalid credentials', { timeout: 2000 })
    expect(authStore.setIsLoggedIn).not.toHaveBeenCalled()
    expect(pushMock).not.toHaveBeenCalled()
  })

  it('sets validation errors when API responds with 422', async () => {
    const wrapper = factory()

    await wrapper.get('input#email').setValue('bad-email')
    await wrapper.get('input#password').setValue('short')

    axios.post.mockRejectedValueOnce({
      response: {
        status: 422,
        data: { errors: { email: ['The email field is required.'] } }
      }
    })

    await wrapper.get('form').trigger('submit.prevent')
    await flushPromises()

    expect(authStore.setValidationErrors).toHaveBeenCalledWith({
      email: ['The email field is required.']
    })
    expect(authStore.isLoading).toBe(false)
    expect(toastError).not.toHaveBeenCalled()
  })
})
