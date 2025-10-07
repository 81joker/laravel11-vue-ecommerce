import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import { useProductStore } from '../../../stores/useProductStore'
import SearchForm from '../../partials/SearchForm.vue'

describe('SearchForm.vue', () => {
  it('enables button when term entered and calls filter for search', async () => {
    const pinia = createTestingPinia({ createSpy: vi.fn })
    const wrapper = mount(SearchForm, { global: { plugins: [pinia] } })
    const store = useProductStore()

    const input = wrapper.get('input')
    const btn = wrapper.get('button.search__button')
    expect(btn.attributes('disabled')).toBeDefined()

    await input.setValue('macbook')
    expect(btn.attributes('disabled')).toBeUndefined()

    await btn.trigger('click')
    expect(store.filterProducts).toHaveBeenCalledWith('find', 'macbook', true)
  })
})
