@extends('layouts.app')

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center mb-16">
      <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
        Golestan University
      </h1>
      <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
        A modern course management system for universities
      </p>
    </div>

    <!-- Main Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
      <!-- Courses Card -->
      <a href="{{ route('courses.index') }}" class="group">
        <div class="relative bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-3 group-hover:bg-indigo-600 transition-colors duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div class="ml-5">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-300">Courses</h3>
                <p class="mt-1 text-sm text-gray-500">Browse and manage university courses</p>
              </div>
            </div>
          </div>
        </div>
      </a>

      <!-- Teachers Card -->
      <a href="{{ route('teachers.index') }}" class="group">
        <div class="relative bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-500 rounded-lg p-3 group-hover:bg-green-600 transition-colors duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div class="ml-5">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-300">Teachers</h3>
                <p class="mt-1 text-sm text-gray-500">Manage faculty members</p>
              </div>
            </div>
          </div>
        </div>
      </a>

      <!-- Students Card -->
      <a href="{{ route('students.index') }}" class="group">
        <div class="relative bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3 group-hover:bg-blue-600 transition-colors duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div class="ml-5">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">Students</h3>
                <p class="mt-1 text-sm text-gray-500">Manage student records</p>
              </div>
            </div>
          </div>
        </div>
      </a>

      <!-- Offerings Card -->
      <a href="{{ route('offerings.index') }}" class="group">
        <div class="relative bg-white rounded-xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
          <div class="p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3 group-hover:bg-purple-600 transition-colors duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="ml-5">
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-300">Offerings</h3>
                <p class="mt-1 text-sm text-gray-500">Manage course enrollments</p>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Quick Stats Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
      <div class="px-6 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Stats</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Total Courses -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
              </div>
              <div class="ml-5">
                <p class="text-sm font-medium text-gray-500">Total Courses</p>
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Course::count() }}</p>
              </div>
            </div>
          </div>

          <!-- Total Teachers -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
              <div class="ml-5">
                <p class="text-sm font-medium text-gray-500">Total Teachers</p>
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Teacher::count() }}</p>
              </div>
            </div>
          </div>

          <!-- Total Students -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div class="ml-5">
                <p class="text-sm font-medium text-gray-500">Total Students</p>
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Student::count() }}</p>
              </div>
            </div>
          </div>

          <!-- Total Offerings -->
          <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="ml-5">
                <p class="text-sm font-medium text-gray-500">Total Offerings</p>
                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Offering::count() }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection